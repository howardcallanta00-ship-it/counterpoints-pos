<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;
class Session extends BaseConfig { public string $driver; public string $cookieName; public int $expiration=7200; public string $savePath; public bool $matchIP=false; public int $timeToUpdate=300; public bool $regenerateDestroy=true; public string $DBGroup='default'; public int $lockRetryInterval=100000; public int $lockMaxRetries=300; public function __construct(){parent::__construct();$this->driver=(string)env('SESSION_DRIVER','CodeIgniter\\Session\\Handlers\\FileHandler');$this->cookieName=(string)env('SESSION_COOKIE_NAME','pos_session');$this->savePath=WRITEPATH.'session';}}
