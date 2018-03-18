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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/results', function () {
	$data = App\Answer::orderBy('id')
 		->orderBy('subject')
 		->get();

    return view('results')->with('answers', $data);

   	 // App\Answer::all()
});

// Route::get('/really/weird/url', function () {
//     App\Answer::truncate();
// });

Route::post('answer/store', 'AnswerController@store');
Route::post('subject/store', 'SubjectController@store');
