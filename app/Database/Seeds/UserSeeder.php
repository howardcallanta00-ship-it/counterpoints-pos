<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
use RuntimeException;
class UserSeeder extends Seeder { public function run(){ $admin=(string)env('SEED_ADMIN_PASSWORD','');if(strlen($admin)<12)throw new RuntimeException('Set SEED_ADMIN_PASSWORD to a temporary password of at least 12 characters before seeding.');$now=date('Y-m-d H:i:s');$accounts=[['admin','System Administrator','admin',$admin],['manager.demo','Demo Manager','manager','DemoManager!2026'],['cashier.one','Avery Lim','cashier','DemoCashier!2026'],['cashier.two','Jordan Tan','cashier','DemoCashier!2026'],['supervisor.demo','Taylor Ramos','manager','DemoManager!2026']];$rows=[];foreach($accounts as [$username,$name,$role,$password])$rows[]=['username'=>$username,'full_name'=>$name,'role'=>$role,'avatar'=>null,'password'=>password_hash($password,PASSWORD_DEFAULT),'created_at'=>$now];$this->db->table('users')->insertBatch($rows); } }
