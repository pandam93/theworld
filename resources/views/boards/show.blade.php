@extends('layouts.app')

@section('content')
    {{-- INCLUDE HEADER --}}
    <div class="row py-4">
        <div class="col">
            <div class="container">
                <div class="text-center">
                    <div class="collapse-trigger pb-2">
                        {{-- Title board --}}
                        <h3>{{ '/' . $board->short_name . '/ - ' . $board->name }}</h3>
                        <hr>
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                No se ha creado el Thread
                            </div>
                        @endif
                        {{-- Description of board --}}
                        <p>{{ $board->description ?? 'Aqui deberia haber una descripcion del board' }}</p>
                        {{-- Button to trigger the create form board --}}
                        <a href="" data-toggle="collapse" data-target="#createThread" aria-expanded="false"
                            aria-controls="createThread">
                            <span class="h3">[ Create a Thread ]</span>
                        </a>
                    </div>
                    <div class="col-8 mx-auto">
                        <div class="collapse card @if ($errors->any()) {{ 'show' }} @endif" id="createThread">
                            <div class="card-body justify-content-start">
                                <form method="POST" action="{{ route('boards.threads.store', [$board]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
                                        <div class="col-sm-10">
                                            <input type="text"
                                                class="form-control required @error('title') is-invalid @enderror "
                                                id="inputTitle" name="title" placeholder="Your shitpost"
                                                value="{{ old('title') }}">
                                            <div class="invalid-feedback text-left">
                                                @error('title')
                                                    · {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="TextareaText" class="col-sm-2 col-form-label my-auto">Text</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control @error('thread_text') is-invalid @enderror"
                                                id="TextareaText" rows="5"
                                                name="thread_text">{{ old('thread_text') }}</textarea>
                                            <div class="invalid-feedback text-left">
                                                @error('thread_text')
                                                    · {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="FileImage" class="col-sm-2 col-form-label">File</label>
                                        <div class="col-sm-10">
                                            <input type="file"
                                                class="form-control-file @error('thread_image') is-invalid @enderror"
                                                id="FileImage" name="thread_image">
                                            <div class="invalid-feedback text-left">
                                                @error('thread_image')
                                                    · {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="InputUrl" class="col-sm-2 col-form-label">URL</label>
                                        <div class="col-sm-10">
                                            <input type="url" class="form-control" id="InputUrl" name="thread_url"
                                                placeholder="url">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">{{ $quote }}</div>
        <div class="card-body">
            @foreach ($threads as $thread)
                <div class="row">
                    <div class="text-center px-2"> {{-- Poner un col aqui le pone demasiado padding a los likes :/ Y encima hace que se desperdicie espacio a la derecha, me cago en todo --}}
                        <div class="row ">
                            <div class="container">
                                <div>
                                    @if (!$thread->likedBy(auth()->user()))
                                        <form id="{{ 'like-form-' . $thread->id }}"
                                            action="{{ route('threads.likes', $thread) }}" method="post">
                                            @csrf
                                            <a href="javascript:{}"
                                                onclick="document.getElementById('{{ 'like-form-' . $thread->id }}').submit(); return false;"><i
                                                    class="fa fa-heart" aria-hidden="true"></i></a>
                                        </form>
                                    @endif
                                    {{-- TODO: route('thread.vote', [$thread->id, 1]) --}}
                                </div>
                                <div style="font-size: 24px; font-weight: bold">{{ $thread->likes->count() }} <br>
                                    {{ Str::plural('like', $thread->likes->count()) }}</div>
                                <div>
                                    @if ($thread->likedBy(auth()->user()))
                                        <form id="{{ 'unlike-form-' . $thread->id }}"
                                            action="{{ route('threads.likes', $thread) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:{}"
                                                onclick="document.getElementById('{{ 'unlike-form-' . $thread->id }}').submit(); return false;"><i
                                                    class="fa fa-heartbeat" aria-hidden="true"></i></a>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-11">

                        <div class="media-body">
                            @if ($thread->thread_image != '')
                                <span class="h6 d-inline-block text-truncate my-0 py-0" style="max-width:156px;">
                                    File:<a
                                        href="{{ asset('storage/threads/' . $thread->id . '/' . $thread->thread_image) }}"
                                        target="_blank">
                                        {{ $thread->thread_image }}
                                    </a>
                                </span>
                                <a href="{{ asset('storage/threads/' . $thread->id . '/thumbnail_' . $thread->thread_image) }}"
                                    target="_blank">
                                    <img class="float-left mr-3 mb-1"
                                        src="{{ asset('storage/threads/' . $thread->id . '/thumbnail_' . $thread->thread_image) }}"
                                        alt="Post Image" style="max-width:340px;max-height:230px;width:auto;height:auto;">
                                </a>
                            @endif
                            <h5 class="card-title mb-2 text-muted">
                                <span class="font-weight-bold text-primary">{{ $thread->title }}</span>
                                {{ $thread->created_at->toDateTimeString() . ' (' . $thread->created_at->shortEnglishDayOfWeek . ') ' }}
                                <a class="badge badge-secondary" href="#">
                                    {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                </a>
                                [<a href="{{ route('boards.threads.show', [$board, $thread,'toReply' => 1]) }}">Reply</a>]
                            </h5>
                        </div>
                        <blockquote class="blockquote my-1">
                            <span class="mx-8 mb-4">{!! nl2br(e($thread->thread_text)) !!}</span>
                        </blockquote>
                        {{-- TODO: ver si se puede mejorar esto --}}
                        @forelse ($thread->replies()->take(3)->get(); as $reply)
                            <div class="card mb-1"
                                style="width: max-content; max-width:100%; background-color: rgba(0,0,255,0.1);">
                                <div class="card-body py-2 pl-3">
                                    @if ($reply->reply_image)
                                        <span class="h6 d-inline-block text-truncate my-0 py-0" style="max-width:156px;">
                                            File:<a
                                                href="{{ asset('storage/threads/' . $thread->id . '/' . $reply->reply_image) }}"
                                                target="_blank">
                                                {{ $reply->reply_image }}
                                            </a>
                                        </span>
                                    @endif
                                    <div class="media">
                                        @if ($reply->reply_image)
                                            <a href="{{ asset('storage/threads/' . $thread->id . '/thumbnail_' . $reply->reply_image) }}"
                                                target="_blank">
                                                <img class="mr-3"
                                                    src="{{ asset('storage/threads/' . $reply->thread->id . '/thumbnail_' . $reply->reply_image) }}"
                                                    alt="Generic placeholder image"
                                                    style="max-width:340px;max-height:230px;width:auto;height:auto;"></a>
                                        @endif
                                        <div class="media-body">
                                            <h6 class="card-subtitle mb-2 mt-1 text-muted"><span
                                                    class="font-weight-bold">{{ $reply->user->username }}</span>
                                                {{ $thread->created_at->toDateTimeString() . ' (' . $thread->created_at->shortEnglishDayOfWeek . ') ' }}
                                                <a id="mylink" class="badge badge-secondary" href="#">
                                                    {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                </a>
                                            </h6>
                                            {!! nl2br(e($reply->reply_text)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <span class="h5 text-muted">No replies yet</span>
            @endforelse
        </div>
    </div>
    <hr />
    @endforeach
    </div>
    {{ $threads->links() }}
    </div>
@endsection
