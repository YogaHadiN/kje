<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asuransi;
use App\Models\Pic;
use App\Models\Email;
use DB;

class revisiPicAsuransi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:revisiPicAsuransi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$asuransis = Asuransi::all();
		$pics      = [];
		$timestamp = date('Y-m-d H:i:s');
		$emails    = [];
		foreach ($asuransis as $asu) {
			if ( !empty( $asu->pic ) ||  !empty($asu->pic)  ) {
				$pics[] = [
					'nama'          => $asu->pic,
					'nomor_telepon' => $asu->hp_pic,
					'asuransi_id'   => $asu->id,
					'tenant_id'     => 1,
					/* 'tenant_id'     => session()->get('tenant_id'), */
					'created_at'    => $timestamp,
					'updated_at'    => $timestamp
				];
			}
			if ( !empty( $asu->email ) ) {
				$emails[] = [
					'email'          => $asu->email,
					'emailable_type' => 'App\\Models\\Asuransi',
					'tenant_id'      => 1,
					/* 'tenant_id'      => session()->get('tenant_id'), */
					'emailable_id'   => $asu->id,
					'created_at'     => $timestamp,
					'updated_at'     => $timestamp
				];
			}
		}
		Email::insert($emails);
		Pic::insert($pics);
		DB::statement('ALTER table asuransis drop column pic, drop column hp_pic, drop column email;');
    }
}
