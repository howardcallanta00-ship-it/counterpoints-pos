<?php
namespace Config;
use CodeIgniter\Events\Events;
Events::on('pre_system',static function(){if(ENVIRONMENT!=='testing'){while(ob_get_level()>0)ob_end_flush();ob_start(static fn($buffer)=>$buffer);}});
