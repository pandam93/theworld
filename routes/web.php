<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', \App\Http\Controllers\WelcomeController::class);

Auth::routes();

//Ya tiene el middleware 'auth' en el constructor del controller.
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('boards', \App\Http\Controllers\BoardController::class);

Route::resource('boards.threads', \App\Http\Controllers\BoardThreadController::class);

Route::group(['middleware' => 'auth'], function() {

    Route::get('/users/{user}',[\App\Http\Controllers\UserController::class, 'show'])->name('users.show');

    Route::resource('users.replies', \App\Http\Controllers\UserReplyController::class);

    Route::get('/users/{user}/threads/liked', [\App\Http\Controllers\UserThreadController::class, 'likedThreads'])->name('users.threads.likedThreads');

    Route::resource('users.threads', \App\Http\Controllers\UserThreadController::class);

    Route::resource('threads.replies', \App\Http\Controllers\ThreadReplyController::class);

    Route::post('threads/{thread_id}/report', [\App\Http\Controllers\BoardThreadController::class, 'report'])->name('thread.report');

    Route::post('/threads/{thread}/likes', [App\Http\Controllers\ThreadLikeController::class, 'store'])->name('threads.likes');
    Route::delete('/threads/{thread}/likes', [App\Http\Controllers\ThreadLikeController::class, 'destroy'])->name('threads.likes');
    
});