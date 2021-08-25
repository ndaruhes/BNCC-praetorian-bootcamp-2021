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

Auth::routes();


// BLOG
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/', 'PageController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'blog'], function () {
        Route::get('', 'BlogController@index')->name('indexBlog');
        Route::get('{id}', 'BlogController@show')->name('showBlog');
        Route::group(['middleware' => 'isMember'], function () {
            Route::post('', 'BlogController@store')->name('storeBlog');
            Route::get('{id}/edit', 'BlogController@edit')->name('editBlog');
            Route::put('{id}', 'BlogController@update')->name('updateBlog');
        });
        Route::delete('{id}', 'BlogController@destroy')->name('deleteBlog');
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::post('', 'CommentController@store')->name('storeComment');
        Route::post('/reply', 'CommentController@replyComment')->name('replyComment');
    });

    Route::group(['prefix' => 'subscribe'], function () {
        Route::post('', 'BlogController@subscribeBlog')->name('subscribeBlog');
    });
});
