<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Config;
use Input;

class ConfigsController extends Controller
{
	public function index(){
		$configs = Config::all();
		return view('configs.index', compact('configs'));
	}
	public function update(){
		$config_variable = Input::get('config_variable');
		$value = Input::get('value');
		$c			= Config::where('config_variable', $config_variable)->first();
		$c->value   = $value ;
		$c->save();
		return $value;
	}
	
	
}
