<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model { protected $table='users'; protected $primaryKey='id'; protected $returnType='array'; protected $useTimestamps=true; protected $allowedFields=['username','full_name','role','avatar','password']; protected $beforeInsert=['hashPassword']; protected $beforeUpdate=['hashPassword']; protected function hashPassword(array $data):array {if(isset($data['data']['password']) && $data['data']['password']!=='' && !password_get_info($data['data']['password'])['algo'])$data['data']['password']=password_hash($data['data']['password'],PASSWORD_DEFAULT);return $data;} }
