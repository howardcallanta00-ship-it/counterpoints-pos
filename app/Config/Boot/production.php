<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', PHP_SAPI === 'cli' ? '1' : '0');
ini_set('display_startup_errors', PHP_SAPI === 'cli' ? '1' : '0');
defined('SHOW_DEBUG_BACKTRACE')||define('SHOW_DEBUG_BACKTRACE',PHP_SAPI === 'cli');
defined('CI_DEBUG')||define('CI_DEBUG',PHP_SAPI === 'cli');
