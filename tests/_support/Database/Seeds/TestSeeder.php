<?php
namespace Tests\Support\Database\Seeds;
use CodeIgniter\Database\Seeder;
class TestSeeder extends Seeder { public function run(){ $now=date('Y-m-d H:i:s');$this->db->table('users')->insert(['username'=>'admin','full_name'=>'Test Admin','role'=>'admin','avatar'=>null,'password'=>password_hash('ValidTest!123',PASSWORD_DEFAULT),'created_at'=>$now]);$this->db->table('customers')->insert(['full_name'=>'Test Customer','email'=>'customer@example.test','phone'=>'5550100','created_at'=>$now]); } }
