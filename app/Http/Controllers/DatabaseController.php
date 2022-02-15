<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Console\Commands\dbBackup;
use App\Console\Commands\sendMeLaravelLog;

class DatabaseController extends Controller
{
	public function index(){
		$db = new dbBackup;
		$db->handle();
		$pesan = Yoga::suksesFlash('Database berhasil di backup');
		return redirect()->back()->withPesan($pesan);
	}
	public function copyLog(){
		$sn = new sendMeLaravelLog;
		$sn->sendLog();
		$pesan = Yoga::suksesFlash('Log File berhasil dikirim');
		return redirect()->back()->withPesan($pesan);
	}
	
}
