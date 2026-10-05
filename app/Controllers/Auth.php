<?php
namespace App\Controllers;
use App\Models\UserModel;
class Auth extends BaseController {
 public function login(){if(session('authenticated'))return redirect()->to('/customers');return view('auth/login',['title'=>'Sign in']);}
 public function attempt(){
  $rules=['username'=>'required|max_length[50]','password'=>'required|max_length[255]'];
  if(!$this->validate($rules))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
  $user=(new UserModel())->where('username',trim((string)$this->request->getPost('username')))->first();
  if(!$user || !password_verify((string)$this->request->getPost('password'),$user['password']))return redirect()->back()->withInput()->with('error','The username or password is incorrect.');
  session()->regenerate(true); session()->set(['user_id'=>(int)$user['id'],'username'=>$user['username'],'role'=>$user['role'],'authenticated'=>true]);
  return redirect()->to('/customers')->with('success','Welcome back, '.$user['full_name'].'.');
 }
 public function logout(){session()->remove(['user_id','username','role','authenticated']);session()->destroy();return redirect()->to('/login')->with('success','You have been signed out.');}
}
