<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Image;
class imageObat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:obat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize Belanja Lain;';

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
		$images = [];
		$errors = [];
		$output = shell_exec('ls /var/www/kje/public/img/belanja/obat/*');
		$array = explode("\n", trim( $output ));
		foreach ($array as $ps) {
			if (!empty( $ps )) {
				try {
					$img = Image::make($ps);

					$img->resize(1000, null, function ($constraint) {
						$constraint->aspectRatio();
						$constraint->upsize();
					})->save();

					$images[] = $ps;
						
				} catch (\Exception $e) {
					$errors[] = $ps;
				}
			}
		}
		return dd([
			$images,	 
			$errors
		]);
    }
}
