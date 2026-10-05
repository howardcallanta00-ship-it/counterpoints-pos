<?php
namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
class Avatars extends BaseController {
 public function show(string $filename){
  if(!preg_match('/^[a-f0-9]{48}\.(jpg|png)$/',$filename))throw PageNotFoundException::forPageNotFound();
  $avatar=db_connect()->table('user_avatars')->where('filename',$filename)->get()->getRowArray();
  if(!$avatar)throw PageNotFoundException::forPageNotFound();
  return $this->response->setHeader('Content-Type',$avatar['mime_type'])->setHeader('Cache-Control','public, max-age=86400')->setBody($avatar['content']);
 }
}
