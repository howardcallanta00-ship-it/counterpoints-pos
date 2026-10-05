<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Libraries\AvatarService;
use CodeIgniter\Exceptions\PageNotFoundException;
class Users extends BaseController {
 private UserModel $users; private AvatarService $avatars; public function __construct(){$this->users=new UserModel();$this->avatars=new AvatarService();}
 public function index(){return view('users/index',['title'=>'Users','users'=>$this->users->orderBy('created_at','DESC')->findAll()]);}
 public function new(){return view('users/form',['title'=>'New user','user'=>null,'action'=>site_url('users')]);}
 public function create(){return $this->persist();}
 public function edit(int $id){return view('users/form',['title'=>'Edit user','user'=>$this->find($id),'action'=>site_url('users/'.$id)]);}
 public function update(int $id){return $this->persist($id);}
 private function persist(?int $id=null){$current=$id?$this->find($id):null;$rules=['username'=>'required|max_length[50]|is_unique[users.username'.($id?',id,'.$id:'').']','full_name'=>'required|max_length[100]','role'=>'required|in_list[admin,manager,cashier]','password'=>($id?'permit_empty':'required').'|min_length[10]|max_length[255]','avatar'=>'if_exist|max_size[avatar,2048]|mime_in[avatar,image/jpg,image/jpeg,image/png]|is_image[avatar]'];if(!$this->validate($rules))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());$data=['username'=>trim((string)$this->request->getPost('username')),'full_name'=>trim((string)$this->request->getPost('full_name')),'role'=>(string)$this->request->getPost('role')];$password=(string)$this->request->getPost('password');if($password!=='')$data['password']=$password;$newAvatar=null;$file=$this->request->getFile('avatar');try{if($file&&$file->getError()!==UPLOAD_ERR_NO_FILE){$newAvatar=$this->avatars->save($file);$data['avatar']=$newAvatar;}$id?$this->users->update($id,$data):$this->users->insert($data);}catch(\Throwable $e){if($newAvatar)$this->avatars->delete($newAvatar);return redirect()->back()->withInput()->with('errors',['avatar'=>$e->getMessage()]);}if($newAvatar&&$current)$this->avatars->delete($current['avatar']);return redirect()->to('/users')->with('success',$id?'User updated successfully.':'User created successfully.');}
 private function find(int $id):array{$record=$id>0?$this->users->find($id):null;if(!$record)throw PageNotFoundException::forPageNotFound('User not found.');return $record;}
}
