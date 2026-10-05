<?php
namespace Config;
use CodeIgniter\Database\Config;
class Database extends Config {
 public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
 public string $defaultGroup = 'default';
 public array $default;
 public array $tests;
 public function __construct() {
  parent::__construct();
  $ssl = env('DB_SSL_CA');
  $this->default = ['DSN'=>'','hostname'=>env('DB_HOST','127.0.0.1'),'username'=>env('DB_USER',''),'password'=>env('DB_PASSWORD',''),'database'=>env('DB_NAME','pos_accounts'),'DBDriver'=>env('DB_DRIVER','MySQLi'),'DBPrefix'=>'','pConnect'=>false,'DBDebug'=>ENVIRONMENT !== 'production','charset'=>'utf8mb4','DBCollat'=>'utf8mb4_unicode_ci','swapPre'=>'','encrypt'=>$ssl ? ['ssl_ca'=>$ssl,'ssl_verify'=>true] : false,'compress'=>false,'strictOn'=>true,'failover'=>[],'port'=>(int)env('DB_PORT',3306),'numberNative'=>false,'foundRows'=>false,'dateFormat'=>['date'=>'Y-m-d','datetime'=>'Y-m-d H:i:s','time'=>'H:i:s']];
  $this->tests = $this->default;
  $this->tests['database'] = env('TEST_DB_NAME','pos_accounts_test');
 }
}
