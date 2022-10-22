<?php

namespace App\Http\Controllers;

use Input; 
use App\Http\Requests;
use Auth;
use App\Models\User;
use App\Models\Classes\Yoga;



class AuthController extends Controller {


	public function index()
	{
		return view('login');
	}

	public function login()
	{
        session()->forget('tenant_id');
		$creds = array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		);

		if( Auth::attempt($creds) ){
			$id = Auth::id();
			$nama = User::find($id)->username;

			return redirect('laporans')->withPesan(Yoga::suksesFlash('Selamat Datang <strong>' . $nama . '</strong>'));
		}else {
			return redirect('login')
			->withInput()
			->withPesan('Kombinasi email dan password Tidak Benar');
		}

	}

	public function logout(){

		Auth::logout();

		return redirect('/');

	}

}
