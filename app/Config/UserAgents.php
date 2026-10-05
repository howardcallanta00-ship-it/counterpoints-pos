<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;
class UserAgents extends BaseConfig {
 public array $platforms=['windows nt 10.0'=>'Windows 10','windows nt 6.3'=>'Windows 8.1','windows nt 6.1'=>'Windows 7','windows phone'=>'Windows Phone','android'=>'Android','iphone'=>'iOS','ipad'=>'iOS','ipod'=>'iOS','os x'=>'Mac OS X','freebsd'=>'FreeBSD','linux'=>'Linux','debian'=>'Debian','unix'=>'Unknown Unix OS'];
 public array $browsers=['OPR'=>'Opera','Edge'=>'Spartan','Edg'=>'Edge','Chrome'=>'Chrome','Opera.*?Version'=>'Opera','Opera'=>'Opera','MSIE'=>'Internet Explorer','Trident.* rv'=>'Internet Explorer','Firefox'=>'Firefox','Safari'=>'Safari','Mozilla'=>'Mozilla','Vivaldi'=>'Vivaldi'];
 public array $mobiles=['iphone'=>'Apple iPhone','ipad'=>'iPad','ipod'=>'Apple iPod Touch','android'=>'Android','blackberry'=>'BlackBerry','windows ce'=>'Windows CE','opera mini'=>'Opera Mini','opera mobi'=>'Opera Mobile','mobile'=>'Generic Mobile','wireless'=>'Generic Mobile','smartphone'=>'Generic Mobile'];
 public array $robots=['googlebot'=>'Googlebot','google-pagerenderer'=>'Google Page Renderer','bingbot'=>'Bing','bingpreview'=>'BingPreview','slurp'=>'Inktomi Slurp','baiduspider'=>'Baiduspider','yandex'=>'YandexBot','duckduckbot'=>'DuckDuckBot','bot'=>'Generic Bot','crawler'=>'Generic Crawler','spider'=>'Generic Spider'];
}
