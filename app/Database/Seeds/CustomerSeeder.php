<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class CustomerSeeder extends Seeder { public function run(){ $now=date('Y-m-d H:i:s');$this->db->table('customers')->insertBatch([
 ['full_name'=>'Maya Santos','email'=>'maya.santos@example.test','phone'=>'+63 917 555 0101','created_at'=>$now],['full_name'=>'Liam Reyes','email'=>'liam.reyes@example.test','phone'=>'+63 917 555 0102','created_at'=>$now],['full_name'=>'Aira Mendoza','email'=>'aira.mendoza@example.test','phone'=>null,'created_at'=>$now],['full_name'=>'Noah Cruz','email'=>'noah.cruz@example.test','phone'=>'+63 917 555 0104','created_at'=>$now],['full_name'=>'Sofia Garcia','email'=>'sofia.garcia@example.test','phone'=>'+63 917 555 0105','created_at'=>$now]
 ]); } }
