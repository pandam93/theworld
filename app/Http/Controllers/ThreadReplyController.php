<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Board;
use App\Models\Reply;
use App\Models\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;



class ThreadReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
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
    public function store(StorePostRequest $request, Thread $thread)
    {
        $reply = $thread->replies()->create($request->validated());

        if (preg_match_all("/\B>>([\d]{7})/", $reply->body, $matches)) {
            foreach ($matches[1] as $id) {
                $replied = Reply::findOrFail((int)$id);
                \Illuminate\Support\Facades\Notification::send($replied->user, new \App\Notifications\MentionUserNotification($reply));
            }
        }

        if ($request->hasFile('reply_file') && $request->file('reply_file')->isValid()) {

            $file = $request->file('reply_file')->getClientOriginalName();

            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            if ($fileExtension == '') {
                $fileExtension = $request->file('reply_file')->guessClientExtension();
                //TODO: mirar algo mejor
            }
            $fileName = pathinfo($file, PATHINFO_FILENAME);

            $request->file('reply_file')
                ->storeAs('threads/' . $thread->board->name . '/' . $thread->id, $fileName . '.' . $fileExtension);

            $fileThumbnailPath = 'threads/' . $thread->board->name . '/' . $thread->id;


            $image = $reply->image()->make([
                'name' => $fileName,
                'type' => $fileExtension,
            ]);



            if (Str::contains($fileExtension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $file = Image::make(storage_path('app/public/threads/' . $thread->board->name . '/' . $thread->id . '/' . $fileName . '.' . $fileExtension))->encode('webp', 80);

                //se puede pero es medio mierdoso, a ver si en la internet lo explican mejor
                // $file->text('GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF GIF ', 50, 50, function ($font) {
                //     $font->file(1);
                //     $font->size(75);
                //     $font->color('#fdf6e3');
                //     $font->align('center');
                //     $font->valign('top');
                //     $font->angle(45);
                // });

                $width = 600; // your max width
                $height = 300; // your max height
                $file->height() > $file->width() ? $width = null : $height = null;
                $file->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $fileExtension = 'webp';

                $image->thumbnail_path = $fileThumbnailPath . '/thumbnail_' . $fileName . '.' . $fileExtension;
                $image->save();

                $file->save(storage_path('app/public/threads/' . $thread->board->name . '/' . $thread->id . '/thumbnail_' . $fileName . '.' . $fileExtension));
            } else {
                $image->thumbnail_path = 'threads/' . $thread->board->name . '/' . $thread->id . '/' . $fileName . '.' . $fileExtension;
                $image->save();
            }
        }
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
    public function edit(Thread $thread, Reply $reply)
    {
        return 'hola';
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
    public function destroy(Thread $thread, Reply $reply)
    {
        $reply->delete();

        return back();
    }
}
