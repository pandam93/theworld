@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <div class="p-6">
                            <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
                            <p>Posted {{ $threads->count() }} {{ Str::plural('thread', $threads->count()) }} and
                                liked {{ $user->threadsLiked->count() }} posts in total</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                Threads
                                <div class="btn-group float-right">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <div class="media mb-2 bg-light">
                                    @if ($thread->image)
                                    <div class="d-flex flex-column">
                                      <div>
                                        <a target="_blank" href="{{ asset('storage/threads/'. $thread->board->name .'/'. $thread->id .'/'. $thread->image->name .'.'. $thread->image->type) }}">
                                          <figcaption class="figure-caption ml-1 mt-1 text-truncate" style="max-width: 200px;">{{ $thread->image->name }}</figcaption>
                                        </a>
                                        </div>
                                      <div>
                                        <img class="p-1" src="{{ asset('storage/'. $thread->image->thumbnail_path) }}" 
                                        alt="image404" style="max-height: 200px; max-width:200px">
                                      </div>
                                    </div>
                                      @endif
                                    <div class="media-body ml-2 mb-2">
                                      @auth
                                        <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                                            @if ($thread->user->id != auth()->user()->id) {{--TODO: poner esto en todos los sitios, o dejarlo solo aqui... --}}
                                            <span class="text-muted">id:</span><a href="{{ route('users.show',$thread->user->username) }}" class="text-dark">{{ $thread->user->username }}</a>
                                            @endif
                                          <small class="text-muted">{{ $thread->created_at->toDateTimeString() }} ({{ $thread->created_at->isToday() ? 'Today' : $thread->created_at->shortEnglishDayOfWeek }})</small>
                                          @can(['delete','update'], $thread)
                                          <form action="{{ route('boards.threads.destroy', [$thread->board, $thread]) }}"
                                              method="post">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                                <i class="gg-trash mt-1 "></i>
                                              </button>
                                          </form>
                                        <form action="{{ route('boards.threads.edit', [$thread->board, $thread]) }}"
                                            method="get">
                                            @csrf
                                            <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                              <i class="gg-pen mt-1"></i>
                                            </button>
                                        </form>
                                          @endcan

                                      
                                      
                                        </span>
                                      @endauth
                                      @guest
                                      <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">{{ 'Anonymous' }}</span>
                                      @endguest
                                      <span class="d-block mt-1 pb-2">
                                        <span class="border-bottom mb-4 pb-1">
                                      <h4 class="d-inline-block mb-0">
                                          <a href="{{ route('boards.threads.show',[$thread->board, $thread]) }}">
                                          {{ $thread->title }} 
                                        </a><i class="gg-arrow-top-right d-inline-block ml-1 mb-1"></i>
                                        <span class="small font-weight-normal align-top">
                                          <a class="badge {{ ($thread->user->id == auth()->user()->id) ? 'badge-primary' : 'badge-secondary' }} mt-1 pt-1" href="#">
                                              {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                          </a>
                                        </span>
                                        <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                        {{ $thread->likes->count() }}
                                                    {{ Str::plural('like', $thread->likes->count()) }} 
                                                        <i class="gg-heart text-danger mb-2 d-inline-block mr-1"></i>
                                                        / 
                                                        <i class="gg-comment d-inline-block mr-1 mb-1"></i>{{ $thread->replies->count() }}
                                                        {{ Str::plural('reply', $thread->replies->count()) }}
                                                        
                                                    </h4>
                                                    <small class="text-muted">liked: {{ $thread->pivot->created_at->isToday() ? $thread->pivot->created_at->diffForHumans()  : $thread->pivot->created_at->toDateTimeString() . ' ('. $thread->pivot->created_at->shortEnglishDayOfWeek .')' }}</small>
                                                  </span>
                                                  </span>
                                                  <p class="h5 mt-2 ml-2">{{ $thread->body }}</p>
                                    </div>
                                </div>

                                {{-- Forma 1 Como idea, vamos, pero creo que mejor un hr solo... --}}
                                {{-- <div class="d-flex justify-content-center">
                                  <i class="gg-arrows-scroll-v d-inline-block"></i>
                                <div class="col-8 flex-row">
                                  <hr class="mt-2">
                                </div>
                                <i class="gg-arrows-scroll-v d-inline-block"></i>
                                </div> --}}
                                
                                {{-- Forma 2 --}}
                                {{-- <div class="col-10 mx-auto">
                                  <hr>
                                </div> --}}

                                {{-- Forma 3 --}}
                                <div class="d-flex">
                                  <div class="col-11 mr-auto">
                                    <hr>
                                  </div>
                                    <i class="gg-quote d-inline-block my-auto"></i>
                                </div>
                                @empty
                                    <blockquote class="blockquote mb-0">
                                        <p>Los que no escriben hilos son tremendos chupapollas.
                                        </p>
                                        <footer class="blockquote-footer">Lo eres? <cite title="Source Title">Parece que si</cite></footer>
                                    </blockquote>
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
