<?php
namespace App\Controllers;
use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
class Customers extends BaseController {
 private CustomerModel $customers; public function __construct(){$this->customers=new CustomerModel();}
 public function index(){return view('customers/index',['title'=>'Customers','customers'=>$this->customers->orderBy('created_at','DESC')->findAll()]);}
 public function new(){return view('customers/form',['title'=>'New customer','customer'=>null,'action'=>site_url('customers')]);}
 public function create(){if(!$this->validate($this->rules()))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());$this->customers->insert($this->payload());return redirect()->to('/customers')->with('success','Customer created successfully.');}
 public function edit(int $id){$customer=$this->find($id);return view('customers/form',['title'=>'Edit customer','customer'=>$customer,'action'=>site_url('customers/'.$id)]);}
 public function update(int $id){$this->find($id);if(!$this->validate($this->rules()))return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());$this->customers->update($id,$this->payload());return redirect()->to('/customers')->with('success','Customer updated successfully.');}
 private function find(int $id):array{$record=$id>0?$this->customers->find($id):null;if(!$record)throw PageNotFoundException::forPageNotFound('Customer not found.');return $record;}
 private function rules():array{return ['full_name'=>'required|max_length[100]','email'=>'required|valid_email|max_length[100]','phone'=>'permit_empty|max_length[20]'];}
 private function payload():array{return ['full_name'=>trim((string)$this->request->getPost('full_name')),'email'=>strtolower(trim((string)$this->request->getPost('email'))),'phone'=>trim((string)$this->request->getPost('phone'))?:null];}
}
