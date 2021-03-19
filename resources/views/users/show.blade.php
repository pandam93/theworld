@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
                <div class="jumbotron">
                    <h1 class="display-4"><i class="gg-profile float-right"></i>{{ $user->name }}</h1>
                    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                    <hr class="my-4">
                    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                  </div>

                  <div class="card mb-4">
                    <h5 class="card-header">
                            Last <a href="{{ route('users.threads.index', $user) }}">threads</a>
                    </h5>
                    <div class="card-body">
                        <div class="card-deck">
                          @forelse ($user->preThreads as $thread)
                          <div class="card">
                            <div class="card-header">
                              <a href="{{ route('boards.threads.show',[$thread->board,$thread]) }}">
                                {{ $thread->title }}
                              </a>
                              -
                              <a class="text-secondary" href="{{ route('boards.show', $thread->board) }}">
                                /{{ $thread->board->key }}/
                              </a>
                            </div>
                            <div class="card-body">
                              <p class="card-text">{{ Str::of($thread->body)->words(25, '(...)') }}</p>
                              <p class="card-text">
                                <small class="text-muted">
                                  {{ $thread->created_at->isToday() ? $thread->created_at->diffForHumans()  : $thread->created_at->toDateTimeString() . ' ('. $thread->created_at->shortEnglishDayOfWeek .')' }}
                                </small>
                              </p>
                            </div>
                          </div>
                          @empty
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">No tienes threads</h5>
                              <p class="card-text">Un poquito mierdas eso de no tener threads, no?.</p>
                            </div>
                          </div>
                          @endforelse
                          </div>
                    </div>
                  </div>

                  <div class="card">
                    <h5 class="card-header">
                            Last <a href="{{ route('users.replies.index', $user) }}">replies</a>
                    </h5>
                    <div class="card-body">
                        <div class="card-deck">
                          @forelse ($user->preReplies as $reply)

                          <div class="card">
                            <div class="card-header">
                              <a href="{{ route('boards.threads.show',[$reply->thread->board,$reply->thread]) }}">
                                {{ $reply->thread->title }}
                              </a>
                              -
                              <a class="text-secondary" href="{{ route('boards.show', $reply->thread->board) }}">
                                /{{ $reply->thread->board->key }}/
                              </a>
                            </div>
                            <div class="card-body">
                              <p class="card-text">{{ Str::of($reply->body)->words(25, '(...)') }}</p>
                              <p class="card-text">
                                <small class="text-muted">
                                  {{ $reply->created_at->isToday() ? $reply->created_at->diffForHumans() : $reply->created_at->toDateTimeString() . ' ('. $reply->created_at->shortEnglishDayOfWeek .')' }}
                                </small>
                              </p>
                            </div>
                          </div>
                          {{-- <div class="card">
                            @if ($reply->reply_file)
                            <div class="text-center">
                              <div>
                                <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $reply->thread->id .'/'. $reply->image->name .'.'. $reply->image->type) }}">
                                  <figcaption class="figure-caption ml-1 text-truncate" style="max-width: 200px;">{{ $reply->image->name }}</figcaption>
                                </a>
                                </div>
                              <div>
                                <img class="p-1" src="{{ asset('storage/'. $reply->image->thumbnail_path) }}" 
                                alt="Generic placeholder image" style="max-height: 200px; max-width:200px">
                              </div>
                            </div>
                            @endif                           
                            <div class="card-body">
                              <h5 class="card-title">{{ $reply->thread->thread_title }}</h5>
                              <p class="card-text">{{ Str::of($reply->body)->limit(20, '(...)') }}</p>
                              <p class="card-text"><small class="text-muted">{{ $reply->updated_at->diffForHumans() }}</small></p>
                            </div>
                          </div> --}}
                          @empty
                          <div class="card-body">
                            <h5 class="card-title">No hay respuestas</h5>
                          </div>
                          @endforelse
                          </div>
                    </div>
                  </div>
        </div>
    </div>
</div>
@endsection
