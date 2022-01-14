<?php


use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('webplayer/{filial}/{tv}','WebPlayerController@play')->name('webplayer.play');
Route::resource('webplayer', WebPlayerController::class);


Route::prefix('admin')->group(function () {
    Route::resource('/filial', FilialController::class);
    Route::get('{filial}/tv/{tv}/autorizar', 'TvController@status')->name('tv.autorizar');
    Route::resource('{filial}/tv', TvController::class);
    Route::resource('{filial}/post', PostController::class);
    Route::get('{filial}/post/{post}/autorizar', 'PostController@autorizar')->name('post.autorizar');
    Route::get('{filial}/post/{post}/status', 'PostController@status')->name('post.status');
    Route::post('{filial}/post/{post}/vincular', 'PostController@vincular')->name('post.vincular');
    Route::post('{filial}/post/{post}/desvincular/{post_tv}', 'PostController@desvincular')->name('post.desvincular');
});





Route::get('/', function () {
    return view('welcome');
});


