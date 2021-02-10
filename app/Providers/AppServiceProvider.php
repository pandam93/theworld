<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Thread;
use App\Models\Board;
use Illuminate\Pagination\Paginator;
use App\Observers\ThreadVoteObserver;
use App\Models\ThreadVote;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
                View::share('newestThreads',Thread::with('board')->latest()->take(5)->get());
                View::share('fattestBoards',Board::withCount('threads')->take(5)->orderBy('threads_count','desc')->get());
        
                //ThreadVote::observe(ThreadVoteObserver::class);
    }
}
