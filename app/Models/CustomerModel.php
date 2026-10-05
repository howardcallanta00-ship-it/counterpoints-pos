<?php
namespace App\Models;
use CodeIgniter\Model;
class CustomerModel extends Model { protected $table='customers'; protected $primaryKey='id'; protected $returnType='array'; protected $useTimestamps=true; protected $allowedFields=['full_name','email','phone']; protected $validationRules=['full_name'=>'required|max_length[100]','email'=>'required|valid_email|max_length[100]','phone'=>'permit_empty|max_length[20]']; protected $validationMessages=['full_name'=>['required'=>'Please enter the customer’s full name.'],'email'=>['required'=>'Please enter an email address.','valid_email'=>'Please enter a valid email address.']]; }
