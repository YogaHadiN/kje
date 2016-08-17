<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BelanjaListsController extends Controller
{
	public function index(){
		return view('belanjalist.index');
	}
	
}
