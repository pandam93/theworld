<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Board;
use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use \Illuminate\Http\Request;
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
        return view('threads.create', compact('board'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThreadRequest $request, Board $board)
    {
        $thread = $board->threads()->create($request->validated());

        if ($request->hasFile('thread_file') && $request->file('thread_file')->isValid()) {

            $file = $request->file('thread_file')->getClientOriginalName();

            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            if ($fileExtension == '') {
                $fileExtension = $request->file('thread_file')->guessClientExtension();
                //TODO: mirar algo mejor
            }
            $fileName = pathinfo($file, PATHINFO_FILENAME);

            $request->file('thread_file')
                ->storeAs('threads/' . $board->name . '/' . $thread->id, $fileName . '.' . $fileExtension);

            $fileThumbnailPath = 'threads/' . $board->name . '/' . $thread->id;


            $image = $thread->image()->make([
                'name' => $fileName,
                'type' => $fileExtension,
            ]);

            //TODO: $image->thumbnail_path = 'lo que sea'

            if (Str::contains($fileExtension, ['jpeg', 'png', 'jpg'])) {
                if ($fileExtension == 'png') {
                    //TODO: quiza mejor y mas rapido pillar la imagen de request->file
                    $file = Image::make(storage_path('app/public/threads/' . $board->name . '/' . $thread->id . '/' . $fileName . '.' . $fileExtension));
                    $width = 600; // your max width
                    $height = 300; // your max height
                    $file->height() > $file->width() ? $width = null : $height = null;
                    $file->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $image->thumbnail_path = $fileThumbnailPath . '/thumbnail_' . $fileName . '.' . $fileExtension;
                    $image->save();
                } else {
                    $file = Image::make(storage_path('app/public/threads/' . $board->name . '/' . $thread->id . '/' . $fileName . '.' . $fileExtension))->encode('webp', 80);
                    $width = 600; // your max width
                    $height = 300; // your max height
                    $file->height() > $file->width() ? $width = null : $height = null;
                    $file->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $fileExtension = 'webp';

                    $image->thumbnail_path = $fileThumbnailPath . '/thumbnail_' . $fileName . '.' . $fileExtension;
                    $image->save();
                }
                $file->save(storage_path('app/public/threads/' . $board->name . '/' . $thread->id . '/thumbnail_' . $fileName . '.' . $fileExtension));
            }
        }
        return redirect()->route('boards.threads.show', [$board, $thread]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board, Thread $thread)
    {
        $thread->load(['replies.user', 'image', 'user', 'replies.image', 'likes']);

        return view('boards.threads.show', compact('board', 'thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board, Thread $thread)
    {

        return view('boards.threads.edit', compact('board', 'thread'));
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

        $thread->update($request->validated());

        if ($request->hasFile('thread_image')) {
            $image = $request->file('thread_image')->getClientOriginalName();
            $request->file('thread_image')
                ->storeAs('threads/' . $thread->id, $image);

            if ($thread->thread_image != '' && $thread->thread_image != $image) {
                unlink(storage_path('app/public/threads/OP_' . $thread->id . '/' . $thread->thread_image));
            }

            $thread->update(['thread_image' => $image]);

            $file = Image::make(storage_path('app/public/threads/OP_' . $thread->id . '/' . $image));
            $width = 100; // your max width
            $height = 100; // your max height
            $file->height() > $file->width() ? $width = null : $height = null;
            $file->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save(storage_path('app/public/threads/OP_' . $thread->id . '/thumbnail_' . $image));
        }

        return redirect()->route('boards.threads.show', [$board, $thread]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, Thread $thread)
    {

        //TODO: que elimine tambien la imagen guardada.
        //TODO: Mirar softDeletes + onCascade.

        $thread->likes->map(function ($item) {
            return $item->delete();
        });

        $thread->replies->map(function ($item) {
            return $item->delete();
        });

        $thread->delete();

        return redirect('/');
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

    public function up(Board $board, Thread $thread)
    {
        if ($thread->user_id != auth()->user()->id) {
            return back();
        }

        // TODO: agregar un campo en la bbdd de los threads que registre el 'ultima vez uppeado' o asi
        // para que solo se pueda uppear una vez al dia.

        $thread->replies()->create([
            'body' => 'Up!',
            'user_id' => auth()->user()->id
        ]);

        return back();
    }
}
