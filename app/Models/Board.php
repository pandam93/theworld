<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Board extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'key'];

    //TODO: quitarlo y usar la sitaxis de board:short_name en la route.
    public function getRouteKeyName()
    {
        return 'key';
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->orderBy('updated_at','desc');
    }
}
