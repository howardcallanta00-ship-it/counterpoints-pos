<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateUsers extends Migration { public function up(){ $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'username'=>['type'=>'VARCHAR','constraint'=>50],'full_name'=>['type'=>'VARCHAR','constraint'=>100],'role'=>['type'=>'VARCHAR','constraint'=>30],'avatar'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'password'=>['type'=>'VARCHAR','constraint'=>255],'created_at'=>['type'=>'DATETIME'],'updated_at'=>['type'=>'DATETIME','null'=>true]]);$this->forge->addKey('id',true);$this->forge->addUniqueKey('username');$this->forge->addKey('role');$this->forge->createTable('users',true,['ENGINE'=>'InnoDB']);} public function down(){$this->forge->dropTable('users',true);} }
