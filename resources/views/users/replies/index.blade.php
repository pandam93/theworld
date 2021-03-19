@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <div class="p-6">
                            <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
                            <p>TEXTO QUE NO SE QUE PONER {{ $user->replies->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                Replies
                                <div class="btn-group float-right">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Order by:
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Created</a>
                                        <a class="dropdown-item" href="#">Boards</a>
                                        <a class="dropdown-item" href="#">Likes</a>
                                        <a class="dropdown-item disabled" href="#">Impact</a>
                                    </div>
                                  </div>
                            </div>
                            <div class="card-body">
                                @forelse ($replies as $reply)
                                <div class="media mb-2 bg-light">
                                    @if ($reply->image)
                                    <div class="d-flex flex-column">
                                      <div>
                                        <a target="_blank" href="{{ asset('storage/threads/'. $reply->thread->board->name .'/'. $reply->thread->id .'/'. $reply->image->name .'.'. $reply->image->type) }}">
                                          <figcaption class="figure-caption ml-1 mt-1 text-truncate" style="max-width: 200px;">{{ $reply->image->name }}</figcaption>
                                        </a>
                                        </div>
                                      <div>
                                        <img class="p-1" src="{{ asset('storage/'. $reply->image->thumbnail_path) }}" 
                                        alt="image404" style="max-height: 200px; max-width:200px">
                                      </div>
                                    </div>
                                      @endif
                                    <div class="media-body ml-2 mb-2">
                                      @auth
                                      <span class="float-right d-flex-column">
                                        <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                                            @if ($user->id != auth()->user()->id) {{--TODO: poner esto en todos los sitios, o dejarlo solo aqui... --}}
                                            <span class="text-muted">id:</span><a href="{{ route('users.show',$thread->user->username) }}" class="text-dark">{{ $reply->user->username }}</a>
                                            @endif
                                          <small class="text-muted">{{ $reply->created_at->toDateTimeString() }} ({{ $reply->created_at->isToday() ? 'Today' : $reply->created_at->shortEnglishDayOfWeek }})</small>
                                          @can('delete', $reply)
                                          <form action="{{ route('threads.replies.destroy', [$reply->thread, $reply]) }}"
                                              method="post">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                                <i class="gg-trash mt-1 "></i>
                                              </button>
                                          </form>
                                          <form action="{{ route('threads.replies.edit', [$reply->thread, $reply]) }}"
                                            method="get">
                                            @csrf
                                            <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                              <i class="gg-pen mt-1"></i>
                                            </button>
                                        </form>
                                      @endcan
                                        </span>
                                        <cite title="Source Title" class="d-block text-right mr-2">{{ '/'. $reply->thread->board->key .'/ - '. $reply->thread->board->name }}</cite>
                                      </span>
                                      @endauth
                                      @guest
                                      <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">{{ 'Anonymous' }}</span>
                                      @endguest
                                      <span class="d-block mt-1 pb-2">
                                        <span class="border-bottom mb-4 pb-1">
                                      <h5 class="d-inline-block mb-0">
                                        id:
                                        <span class="align-text-top font-weight-normal">
                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                          </a>
                                        </span>
                                        {{-- TODO: todo esto, ofc --}}
                                        <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                        {{-- $reply->likes->count() --}}
                                          0
                                                    {{-- Str::plural('like', $thread->likes->count()) --}}
                                                     likes
                                                        <i class="gg-heart text-danger mb-2 d-inline-block mr-1"></i>
                                                        / 
                                                        3
                                                          mentions
                                                        <i class="gg-trending d-inline-block mr-2"></i>
                                                        <span class="small font-weight-normal align-middle">
                                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a> ,
                                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a> ,
                                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a> ,
                                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a>
                                                        </span>                                                        
                                                    </h5>
                                                  </span>
                                                  </span>

                                                        <p class="mt-4 mx-2 ">{{ $reply->body }}</p>
                                                        <footer class="font-italic position-relative align-bottom">                                            
                                                          <span class="mb-4 pb-1 d-inline align-bottom">
                                                          -
                                                          <a href="{{ route('boards.threads.show',[$reply->thread->board, $reply->thread]) }}">
                                                          {{ $reply->thread->title }} 
                                                        </a><i class="gg-arrow-top-right d-inline-block ml-1 mb-1"></i>
                                                        <span class="small font-weight-normal align-top">
                                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->thread->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a>
                                                        </span>
                                                        <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                        {{-- {{ $thread->likes->count() }}
                                                                    {{ Str::plural('like', $thread->likes->count()) }} 
                                                                        <i class="gg-heart text-danger mb-2 d-inline-block mr-1"></i> --}}
                                                                    <small class="text-muted">Replied: {{ $reply->created_at->isToday() ? $reply->created_at->diffForHumans()  : $reply->created_at->toDateTimeString() . ' ('. $reply->created_at->shortEnglishDayOfWeek .')' }}</small>
                                                                  </span></footer>
              

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
                                        <p>Los que no escriben respuestas son tremendos chupapollas.
                                        </p>
                                        <footer class="blockquote-footer">Lo eres? <cite title="Source Title">Parece que si</cite></footer>
                                    </blockquote>
                                @endforelse
                            </div>
                            <div class="ml-4">
                                {{ $replies->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
