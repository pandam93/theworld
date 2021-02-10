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

Route::get('/', \App\Http\Controllers\WelcomeController::class)->name('home');


Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::resource('boards', \App\Http\Controllers\BoardController::class);

    Route::get('boards/{board}/threads/{thread}', [ \App\Http\Controllers\BoardThreadController::class, 'show'])
        ->name('boards.threads.show');

    Route::resource('boards.threads', \App\Http\Controllers\BoardThreadController::class)
    ->except('show');

    Route::resource('threads.replies', \App\Http\Controllers\ThreadReplyController::class);

    Route::post('threads/{thread_id}/report', [\App\Http\Controllers\BoardThreadController::class, 'report'])->name('thread.report');

    Route::post('/threads/{thread}/likes', [App\Http\Controllers\ThreadLikeController::class, 'store'])->name('threads.likes');
    Route::delete('/threads/{thread}/likes', [App\Http\Controllers\ThreadLikeController::class, 'destroy'])->name('threads.likes');
    
});