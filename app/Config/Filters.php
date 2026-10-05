<?php
namespace Config;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;
class Filters extends BaseFilters {
 public array $aliases = ['csrf'=>CSRF::class,'toolbar'=>\CodeIgniter\Filters\DebugToolbar::class,'honeypot'=>Honeypot::class,'invalidchars'=>InvalidChars::class,'secureheaders'=>SecureHeaders::class,'forcehttps'=>\CodeIgniter\Filters\ForceHTTPS::class,'pagecache'=>\CodeIgniter\Filters\PageCache::class,'performance'=>\CodeIgniter\Filters\PerformanceMetrics::class,'auth'=>AuthFilter::class];
 public array $required = ['before'=>['forcehttps','pagecache'],'after'=>['pagecache','performance','toolbar']];
 public array $globals = ['before'=>['csrf'],'after'=>['secureheaders']];
 public array $methods = [];
 public array $filters = [];
}
