<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WablasController;

class TestKirimWaAPIButtonKeIphone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:wabutton';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim wa API ke Iphone, diharapkan ke android sudah pasti lancar';

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
     * @return int
     */
    public function handle()
    {
        $wa = new WablasController;

        $wa->sendSingle('6281381912803', 'Setelah ini akan mengirim test untuk button');
        $data = [
            [
                'phone' => '6281381912803',
                'message' => [
                    'buttons' => ["button 1","button 2","button 3"],
                    'content' => 'sending template message...',
                    'footer' => 'footer template here',
                ],
            ]
        ];

        $wa->sendButton($data);
    }
}
