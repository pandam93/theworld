<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait; //TODO: Agregar SoftDeletes

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function board()
    {
        return $this->hasOne(Board::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function preThreads()
    {
        return $this->threads()->take(3)->orderBy('id', 'desc');
    }

    public function preReplies()
    {
        return $this->replies()->take(3)->orderBy('id', 'desc');
    }

    public function receivedLikes()
    {
        return $this->hasManyThrough(Like::class, Thread::class);
    }
}
