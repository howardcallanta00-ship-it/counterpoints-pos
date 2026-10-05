<?php
namespace App\Controllers;
class Pages extends BaseController { public function home(){return view('pages/home',['title'=>'Modern account control for every checkout']);} public function about(){return view('pages/about',['title'=>'About Counterpoint']);} }
