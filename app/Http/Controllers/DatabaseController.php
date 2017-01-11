<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\Console\Commands\dbBackup;

class DatabaseController extends Controller
{
	public function index(){
		$db = new dbBackup;
		$db->handle();
		$pesan = Yoga::suksesFlash('Database berhasil di backup');
		return redirect()->back()->withPesan($pesan);
	}
	
}
