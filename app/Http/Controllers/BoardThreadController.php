<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Gate;



class BoardThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board)
    {
        $threads = $board->threads()->latest('id')->with(['user', 'likes'])->paginate(10);

        return view('boards.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Board $board)
    {
        return view('threads.create',compact('board'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThreadRequest $request, Board $board)
    {

        $thread = $board->threads()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'thread_text' => $request->thread_text ?? null,
            'thread_url' => $request->thread_url ?? null,
        ]);

        

        if($request->hasFile('thread_image')){
            $image = $request->file('thread_image')->getClientOriginalName();
            $request->file('thread_image')
                    ->storeAs('threads/' . $thread->id,$image);
            $thread->update(['thread_image' => $image]);

            $file = Image::make(storage_path('app/public/threads/' . $thread->id .'/'. $image));
            $width = 600; // your max width
            $height = 300; // your max height
            $file->height() > $file->width() ? $width=null : $height=null;
            $file->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save(storage_path('app/public/threads/' . $thread->id . '/thumbnail_'. $image));
        }

        return redirect()->route('boards.show', $board);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board, Thread $thread)
    {
        $thread->load('replies.user');
        
        return view('boards.threads.show', compact('board','thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board, Thread $thread)
    {
        if(Gate::denies('edit-thread',$thread)){
            abort(403);
        }
        
        return view('threads.edit',compact('board','thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreThreadRequest $request, Board $board, Thread $thread)
    {
        if(Gate::denies('edit-thread',$thread)){
            abort(403);
        }

        $thread->update($request->validated());

        if($request->hasFile('thread_image')){
            $image = $request->file('thread_image')->getClientOriginalName();
            $request->file('thread_image')
                    ->storeAs('threads/' . $thread->id,$image);

            if($thread->thread_image != '' && $thread->thread_image != $image){
                unlink(storage_path('app/public/threads/OP_'. $thread->id . '/' . $thread->thread_image));
            }

            $thread->update(['thread_image' => $image]);

            $file = Image::make(storage_path('app/public/threads/OP_' . $thread->id .'/' . $image));
            $width = 100; // your max width
            $height = 100; // your max height
            $file->height() > $file->width() ? $width=null : $height=null;
            $file->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save(storage_path('app/public/threads/OP_' . $thread->id . '/thumbnail_'. $image));

        }

        return redirect()->route('boards.threads.show',[$board, $thread]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, Thread $thread)
    {
        if(Gate::denies('delete-thread', $thread)){
            abort(403);
        }

        $thread->delete();

        return redirect()->route('boards.show',[$board]);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report($thread_id)
    {
        // $thread = Thread::with('board.user')->findOrFail($thread_id);

        // $thread->board->user->notify(new ThreadReportNotification($thread));

        // return redirect()->route('boards.threads.show', [$thread->id])
        //     ->with('message', 'Your report has been sent.');
    }
}
