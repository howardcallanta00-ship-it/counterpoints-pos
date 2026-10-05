<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateUserAvatars extends Migration {
 public function up(){
  $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'filename'=>['type'=>'VARCHAR','constraint'=>64],'mime_type'=>['type'=>'VARCHAR','constraint'=>20],'content'=>['type'=>'MEDIUMBLOB'],'created_at'=>['type'=>'DATETIME']]);
  $this->forge->addKey('id',true);$this->forge->addUniqueKey('filename');$this->forge->createTable('user_avatars',true,['ENGINE'=>'InnoDB']);
 }
 public function down(){$this->forge->dropTable('user_avatars',true);}
}
