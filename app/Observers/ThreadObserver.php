<?php

namespace App\Observers;

use App\Models\Thread;

class ThreadObserver
{
    /**
     * Handle the Thread "created" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function created(Thread $thread)
    {
                
        if(preg_match_all('/\B@(\w+)/', $thread->thread_text, $matches)){
                
            foreach($matches[1] as $user){
                $foundUser = \App\Models\User::where('username', $user)->first();

                if($foundUser){
                    \Illuminate\Support\Facades\Notification::send($foundUser, new \App\Notifications\MentionUserNotification($thread));
                }
            }
        }
    }

    /**
     * Handle the Thread "updated" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function updated(Thread $thread)
    {
        //
    }

    /**
     * Handle the Thread "deleted" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function deleted(Thread $thread)
    {
        //
    }

    /**
     * Handle the Thread "restored" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function restored(Thread $thread)
    {
        //
    }

    /**
     * Handle the Thread "force deleted" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function forceDeleted(Thread $thread)
    {
        //
    }
}
