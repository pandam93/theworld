<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Board extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'description', 'short_name'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function getRouteKeyName()
    {
        return 'short_name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->orderBy('updated_at','desc');
    }
}
