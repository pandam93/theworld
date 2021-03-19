<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadLikeController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth']);
    }
    
    public function store(Thread $thread, Request $request)
    {
        if ($thread->likedBy($request->user())) {
            return response(null, 409);
        }

        $thread->likes()->create([
            'user_id' => $request->user()->id,
            'thread_id' => $thread->id,
        ]);

        // if (!$thread->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) {
        //     Mail::to($thread->user)->send(new ThreadLiked(auth()->user(), $thread));
        // }

        return back();
    }

    public function destroy(Thread $thread, Request $request)
    {
        $request->user()->likes()->where('thread_id', $thread->id)->delete();

        return back();
    }
}
