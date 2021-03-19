<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function delete(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id;
    }

    public function update(User $user, Thread $thread)
    {
        return $user->id === $thread->user_id;
    }

    public function view(User $user, Thread $thread)
    {
        return $user->id === $thread->user->id;
    }
}