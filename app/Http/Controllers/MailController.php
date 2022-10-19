<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MailNoitify;

class MailController extends Controller
{
    public function index(){
        $data = [
            'subject' => 'testing email',
            'body' => 'Email sending successfull'
        ];
        Mail::to('yogahn89@gmail.com')->send(new MailNoitify($data));
    }
}
