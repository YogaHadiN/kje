<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Sms;
use Log;
use Input;
use Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
		 if (!empty( trim( $e->getMessage() ) )) {
			// emails.exception is the template of your email
			// it will have access to the $error that we are passing below
			 Log::info('URL YANG error : ' . Input::fullUrl());
			 Log::info('Method yang error : ' . Input::method());
			 Log::info('Pada Jam : ' . date('Y-m-d H:i:s'));
			 if (gethostname() != 'dell') {
				 //Mail::send('email.error', [
					 //'url'    => Input::url(),
					 //'method' => Input::method(),
					 //'error'  => $e->getMessage() . ' pada jam ' . date('Y-m-d H:i:s')
				 //], function($m){
					  //$m->from('admin@mailgun.org', 'Yoga Hadi Nugroho');
					  //$m->to('yoga_email@yahoo.com', 'Yoga Hadi Nugroho');
					  //$m->subject('Error from KJE');
				 //});
				 Sms::send('081381912803',$e->getMessage() . ' pada jam ' . date('Y-m-d H:i:s') );
			 }
		}
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        }else{
            return $this->renderWithWoops($e);
        }
    }

    protected function renderWithWoops(Exception $e){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

        return new Response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
            
    }
}
