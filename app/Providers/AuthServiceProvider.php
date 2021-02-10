<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Thread;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('delete-thread', function(User $user, Thread $thread) {
            return $user->is_admin || in_array($user->id, [$thread->user_id, $thread->board->user_id]);
        });

        Gate::define('edit-thread', function(User $user, Thread $thread){
            return $thread->user_id == $user->id;
        });
    }
}
