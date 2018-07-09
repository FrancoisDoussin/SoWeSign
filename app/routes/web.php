<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Smalot\PdfParser\Parser;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
//    $parser = new Parser();
//    $pdf = $parser->parseFile('test.pdf');
//
//   foreach($pdf->getPages() as $i => $page) {
//       dump($page);
//   }

    $pdf2text = new \Pdf2text\Pdf2text('test.pdf');
    $output = $pdf2text->decode();

    dd($output);
});