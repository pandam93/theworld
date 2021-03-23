@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">

                <div class="jumbotron">
                    <h1 class="display-4">Hello, {{ $user->name }}!</h1>
                    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra
                        attention to featured content or information.</p>
                    <hr class="my-4">
                    <p>Posted {{ $threads->count() }} {{ Str::plural('thread', $threads->count()) }} and
                        received {{ $user->receivedLikes->count() }} likes in total
                    </p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                    </p>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                Threads
                                <div class="btn-group float-right">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Order by:
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Created</a>
                                        <a class="dropdown-item" href="#">Updated</a>
                                        <a class="dropdown-item" href="#">Likes</a>
                                        <a class="dropdown-item" href="#">Replies</a>
                                        <a class="dropdown-item disabled" href="#">Impact</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @forelse ($threads as $thread)
                                    <div class="media bg-light" id="t{{ $thread->id }}">
                                        @if ($thread->image)
                                            <div class="d-flex flex-column pt-1 pl-1 pb-1" style="max-width: 300px;">
                                                <a target="_blank"
                                                    href="{{ asset('storage/threads/' . $thread->board->name . '/' . $thread->id . '/' . $thread->image->name . '.' . $thread->image->type) }}">
                                                    <figcaption class="figure-caption text-truncate">
                                                        {{ $thread->image->name }}</figcaption>
                                                </a>
                                                <img class="img-responsive"
                                                    src="{{ asset('storage/' . $thread->image->thumbnail_path) }}"
                                                    alt="image404" style="max-height: 250px;">
                                            </div>
                                        @endif
                                        <div class="media-body ml-2">
                                            <div class="op">
                                                <span class="float-right shadow-sm p-1 bg-white rounded">
                                                    @if ($thread->user->id != auth()->user()->id)

                                                        <span class="text-muted">id:</span><a
                                                            href="{{ route('users.show', $thread->user->username) }}"
                                                            class="text-dark">{{ $thread->user->username }}</a>
                                                        /
                                                    @endif
                                                    <small class="text-muted">{{ $thread->created_at->toDateTimeString() }}
                                                        ({{ $thread->created_at->isToday() ? 'Today' : $thread->created_at->shortEnglishDayOfWeek }})</small>
                                                </span>
                                                <span class="h3">
                                                    <a
                                                        href="{{ route('boards.threads.show', [$thread->board, $thread]) }}">{{ $thread->title }}</a>
                                                </span>
                                                <a class="badge {{ $thread->user->id == auth()->user()->id ? 'badge-primary' : 'badge-secondary' }} pt-1 align-text-top"
                                                    href="#">
                                                    {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                                </a>
                                                <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                <small class="text-muted">last updated:
                                                    {{ $thread->updated_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mx-2 mt-2">{{ $thread->body }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6 mx-auto flex-row">
                                        <hr>
                                    </div>
                                @empty
                                    <h5>No threads</h5>
                                @endforelse
                            </div>
                            <div class="ml-4">
                                {{ $threads->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
