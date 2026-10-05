<?php
namespace App\Commands;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
class BootstrapAdmin extends BaseCommand {
 protected $group='Counterpoint';protected $name='app:bootstrap-admin';protected $description='Creates the initial administrator once from SEED_ADMIN_PASSWORD.';
 public function run(array $params){$password=(string)env('SEED_ADMIN_PASSWORD','');if(strlen($password)<12){CLI::error('SEED_ADMIN_PASSWORD must contain at least 12 characters.');return EXIT_ERROR;}$users=new UserModel();if($users->where('username','admin')->first()){CLI::write('Administrator already exists; no changes made.','yellow');return EXIT_SUCCESS;}$users->insert(['username'=>'admin','full_name'=>'System Administrator','role'=>'admin','password'=>$password]);CLI::write('Initial administrator created. Remove SEED_ADMIN_PASSWORD now.','green');return EXIT_SUCCESS;}
}
