@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row mb-2">
                    <div class="container">
                        <div class="text-center">
                            <div class="collapse-trigger pb-2">
                                {{-- Title board --}}
                                <h3>{{ '/' . $board->key . '/ - ' . $board->name }}</h3>
                                <hr>
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        No se ha creado el Thread
                                    </div>
                                @endif
                                {{-- Description of board --}}
                                <p>{{ $board->description ?? 'Aqui deberia haber una descripcion del board' }}</p>
                                {{-- Button to trigger the create form board --}}
                                <div class="mb-3">
                                    <img src="{{ asset('img/banner.jpg') }}" class="img-fluid" alt="Responsive image"
                                        style="max-width: 50%">
                                </div>
                                @auth
                                    <a href="" data-toggle="collapse" data-target="#createThread" aria-expanded="false"
                                        aria-controls="createThread">
                                        <span class="h3">[ Create a Thread ]</span>
                                    </a>
                                @endauth
                            </div>
                            @auth
                                <div class="col-8 mx-auto">
                                    <div class="collapse card @if ($errors->any()) {{ 'show' }} @endif" id="createThread">
                                        <div class="card-header">Form thread</div>
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
                                                    <label for="TextareaText"
                                                        class="col-sm-2 col-form-label my-auto">Text</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control @error('body') is-invalid @enderror"
                                                            id="TextareaText" rows="5"
                                                            name="body">{{ old('body') }}</textarea>
                                                        <div class="invalid-feedback text-left">
                                                            @error('body')
                                                                · {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="FileImage" class="col-sm-2 col-form-label">File</label>
                                                    <div class="col-sm-10">
                                                        <input type="file"
                                                            class="form-control-file @error('thread_file') is-invalid @enderror"
                                                            id="FileImage" name="thread_file">
                                                        <div class="invalid-feedback text-left">
                                                            @error('thread_file')
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
                                                <div class="form-group row">
                                                    <label for="FormControlOption"
                                                        class="col-sm-2 col-form-label">Options</label>
                                                    <div class="col-sm-10">
                                                        <select class="select2-multiple form-control" name="options[]"
                                                            multiple="multiple">
                                                            <option value="prv">+prv</option>
                                                            <option value="hd">+HD</option>
                                                            <option value="temaserio">+temaserio</option>
                                                            <option value="18">+18</option>
                                                            <option value="16">+16</option>
                                                            <option value="video">+video</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Post</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">{{ $board->name }}</div>
                            <div class="card-body">
                                @forelse ($board->threads as $thread)
                                    <div class="media bg-light" id="t{{ $thread->id }}">
                                        @if ($thread->image)
                                            <div class="d-flex flex-column pt-1 pl-1 pb-1">
                                                <a target="_blank"
                                                    href="{{ asset('storage/threads/' . $board->name . '/' . $thread->id . '/' . $thread->image->name . '.' . $thread->image->type) }}">
                                                    <figcaption class="figure-caption text-truncate">
                                                        {{ $thread->image->name }}</figcaption>
                                                </a>
                                                <img id='img_{{ $thread->id }}' class="img-responsive"
                                                    src="{{ asset('storage/' . $thread->image->thumbnail_path) }}"
                                                    alt="image404" onclick="zoomImage('img_{{ $thread->id }}')"
                                                    style="max-height: 250px;max-width:300px">
                                            </div>
                                        @endif
                                        <div class="media-body ml-2">
                                            <div class="op">
                                                @auth
                                                    <span class="float-right shadow-sm p-1 bg-white rounded">
                                                        @if ($thread->user->id != auth()->user()->id)

                                                            <span class="text-muted">id:</span><a
                                                                href="{{ route('users.show', $thread->user->username) }}"
                                                                class="text-dark">{{ $thread->user->username }}</a>
                                                            /
                                                        @endif
                                                        <small
                                                            class="text-muted">{{ $thread->created_at->toDateTimeString() }}
                                                            ({{ $thread->created_at->isToday() ? 'Today' : $thread->created_at->shortEnglishDayOfWeek }})</small>
                                                    </span>
                                                @endauth
                                                @guest
                                                    <span
                                                        class="float-right shadow-sm p-1 bg-white rounded">{{ 'Anonymous' }}</span>
                                                @endguest
                                                <span class="h2">
                                                    <a
                                                        href="{{ route('boards.threads.show', [$thread->board, $thread]) }}">{{ $thread->title }}</a>
                                                </span>
                                                @auth
                                                    <a class="badge {{ $thread->user->id == auth()->user()->id ? 'badge-primary' : 'badge-secondary' }} pt-1 align-text-top"
                                                        href="{{ route('boards.threads.show', [$thread->board, $thread]) }}/#postReplyForm">
                                                        {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                    <small class="text-muted">last updated:
                                                        {{ $thread->updated_at->diffForHumans() }}</small>
                                                @endauth
                                            </div>
                                            <p class="mx-2 mt-2">{{ $thread->body }}</p>
                                            @forelse ($thread->preReplies->reverse() as $reply)
                                                <div id="r{{ $reply->id }}" class="media m-3 border border-dark"
                                                    style="min-height: 5rem">
                                                    @if ($reply->image)
                                                        <div class="d-flex flex-column pl-1 pt-1 pb-1">
                                                            <a target=" _blank"
                                                                href="{{ asset('storage/threads/' . $board->name . '/' . $reply->thread->id . '/' . $reply->image->name . '.' . $reply->image->type) }}">
                                                                <figcaption class="figure-caption text-truncate">
                                                                    {{ $reply->image->name }}
                                                                </figcaption>
                                                            </a>
                                                            <img id='img_{{ $reply->id }}' class="img-responsive"
                                                                src="{{ asset('storage/' . $reply->image->thumbnail_path) }}"
                                                                alt="Generic placeholder image"
                                                                onclick="zoomImage('img_{{ $reply->id }}')"
                                                                style="max-height: 250px; max-width:300px">
                                                        </div>
                                                    @endif
                                                    <div class="media-body ml-2">
                                                        <div class="reply mb-2">
                                                            @auth
                                                                <span class="float-right shadow-sm p-1 bg-white rounded">
                                                                    @if ($reply->user->id != auth()->user()->id)
                                                                        {{-- TODO: poner esto en todos los sitios, o dejarlo solo aqui... --}}
                                                                        <span class="text-muted">id:</span><a
                                                                            href="{{ route('users.show', $reply->user->username) }}"
                                                                            class="text-dark">{{ $reply->user->username }}</a>
                                                                        /
                                                                    @endif
                                                                    <small
                                                                        class="text-muted">{{ $reply->created_at->toDateTimeString() }}
                                                                        ({{ $reply->created_at->isToday() ? 'Today' : $reply->created_at->shortEnglishDayOfWeek }})</small>
                                                                </span>
                                                            @endauth
                                                            @guest
                                                                <span
                                                                    class="float-right shadow-sm p-1 bg-white rounded">{{ 'Anonymous' }}</span>
                                                                <h4 class="pt-1 invisible">Reply
                                                                </h4>
                                                            @endguest
                                                            @auth
                                                                <span class="h2"></span>
                                                                <a class="badge {{ $reply->user->id == auth()->user()->id ? 'badge-primary' : 'badge-secondary' }} pt-1 align-text-top"
                                                                    href="{{ route('boards.threads.show', [$reply->thread->board, $reply->thread]) }}/#{{ $reply->id }}">
                                                                    {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                                </a>
                                                                <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                                <small class="text-muted">last updated:
                                                                    {{ $reply->updated_at->diffForHumans() }}</small>
                                                            @endauth
                                                        </div>
                                                        <p class="mx-2">{{ $reply->body }}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="mx-2">No replies yet</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="col-6 mx-auto flex-row">
                                        <hr>
                                    </div>
                                @empty
                                    <h5>No threads</h5>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
