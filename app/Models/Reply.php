<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reply extends Model
{
    use HasFactory, HasFactory;

    protected $fillable = ['thread_id', 'user_id','reply_text','reply_image','reply_url'];

    protected $touches = ['thread'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function thread(){
        return $this->belongsTo(Thread::class);
    }
    
    public function getReplyText(){
            return Str::title($this->reply_text);
    }
}
