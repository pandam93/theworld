<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Thread;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id'
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
