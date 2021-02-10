<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Board;
use App\Models\Reply;
use Intervention\Image\ImageManagerStatic as Image;


class ThreadReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Thread $thread, Reply $reply)
    {
        $thread->load('board');
        
        $reply = $thread->replies()->create([
            'user_id' => auth()->id(),
            'reply_text' => $request->reply_text ?? null,
            'reply_image' => $request->reply_image ?? null,
            'reply_url' => $request->reply_url ?? null,

        ]);

        if($request->hasFile('reply_image')){
            $image = $request->file('reply_image')->getClientOriginalName();
            $request->file('reply_image')
                    ->storeAs('threads/' . $reply->thread->id,$image);
            $reply->update(['reply_image' => $image]);

            $file = Image::make(storage_path('app/public/threads/' . $reply->thread->id .'/'. $image));
            $width = 600; // your max width
            $height = 300; // your max height
            $file->height() > $file->width() ? $width=null : $height=null;
            $file->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save(storage_path('app/public/threads/' . $reply->thread->id . '/thumbnail_'. $image));
        }

        // $thread->update([
        //     'updated_at' => now(),
        // ]);

        return redirect()->route('boards.threads.show', [$thread->board, $thread]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //return view('boards.thread.show',[$board,$thread]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
