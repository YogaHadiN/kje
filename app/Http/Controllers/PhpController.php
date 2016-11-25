<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PhpController extends Controller
{
	public function index(){
		phpinfo();
	}
	
}
