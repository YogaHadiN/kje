<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Input;
/* use Builder; */
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


class QrCodeController extends Controller
{
    public function index(){
		$result = Builder::create()
			->writer(new PngWriter())
			->writerOptions([])
			->data( Input::get('text') )
			->encoding(new Encoding('UTF-8'))
			->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			->size(200)
			->margin(1)
			->roundBlockSizeMode(new RoundBlockSizeModeMargin())
			/* ->logoPath(__DIR__.'/assets/symfony.png') */
			/* ->labelText('This is the label') */
			/* ->labelFont(new NotoSans(20)) */
			/* ->labelAlignment(new LabelAlignmentCenter()) */
			->build();
		return $result->getString();
    }

    public function inPdf($text){
		$result = Builder::create()
			->writer(new PngWriter())
			->writerOptions([])
			->data($text)
			->encoding(new Encoding('UTF-8'))
			->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			->size(200)
			->margin(1)
			->roundBlockSizeMode(new RoundBlockSizeModeMargin())
			/* ->logoPath(__DIR__.'/assets/symfony.png') */
			/* ->labelText('This is the label') */
			/* ->labelFont(new NotoSans(20)) */
			/* ->labelAlignment(new LabelAlignmentCenter()) */
			->build();
		return $result->getDataUri();
    }
}

