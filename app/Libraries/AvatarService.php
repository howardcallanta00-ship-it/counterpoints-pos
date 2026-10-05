<?php
namespace App\Libraries;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;
class AvatarService {
 public function directory():string{$configured=trim((string)env('AVATAR_UPLOAD_PATH',''));$path=$configured!==''?$configured:FCPATH.'uploads'.DIRECTORY_SEPARATOR.'avatars';if(!is_dir($path)&&!mkdir($path,0755,true)&&!is_dir($path))throw new RuntimeException('Avatar storage is unavailable.');return rtrim(realpath($path)?:$path,'\\/');}
 public function save(UploadedFile $file):string {if(!$file->isValid())throw new RuntimeException($file->getErrorString()?:'The avatar upload failed.');if($file->getSize()>2097152)throw new RuntimeException('The avatar must be 2 MB or smaller.');$mime=(new \finfo(FILEINFO_MIME_TYPE))->file($file->getTempName());$map=['image/jpeg'=>'jpg','image/png'=>'png'];if(!isset($map[$mime])||@getimagesize($file->getTempName())===false)throw new RuntimeException('Choose a valid JPG or PNG image.');$name=bin2hex(random_bytes(24)).'.'.$map[$mime];$target=$this->directory().DIRECTORY_SEPARATOR.$name;service('image','gd')->withFile($file->getTempName())->fit(300,300,'center')->save($target,88);if(!is_file($target))throw new RuntimeException('The avatar could not be processed.');return $name;}
 public function delete(?string $name):void {if(!$name||!preg_match('/^[a-f0-9]{48}\.(jpg|png)$/',$name))return;$dir=$this->directory();$path=$dir.DIRECTORY_SEPARATOR.$name;$real=is_file($path)?realpath($path):false;if($real&&str_starts_with($real,$dir.DIRECTORY_SEPARATOR))@unlink($real);}
}
