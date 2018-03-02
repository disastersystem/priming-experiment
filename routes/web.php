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
    return view('results')
    	->with( 'answers', App\Answer::all() );
});

Route::post('answer/store', 'AnswerController@store');

Route::post('subject/store', 'SubjectController@store');
