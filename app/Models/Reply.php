<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reply extends Model
{
    use HasFactory, HasFactory, SoftDeletes; //TODO: Agregar SoftDeletes

    protected $fillable = ['user_id', 'body'];

    protected $touches = ['thread'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function thread(){
        return $this->belongsTo(Thread::class);
    }

    /**
     * 
     * Get the user's image.
     * 
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    public function getReplyText(){
            return Str::title($this->reply_text);
    }
}
