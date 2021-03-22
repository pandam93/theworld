@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-11">
              <div class="row">
                  <div class="col mb-2">
                    
                    <div class="text-center">
                          {{-- Title board --}}
                          <h3>{{ '/' . $board->key . '/ - ' . $board->name }}</h3>
                          <hr>
                          {{-- Description of board --}}
                          <p>{{ $board->description ?? 'Aqui deberia haber una descripcion del board' }}</p>
                    </div>
                    
                    
                      <div class="card">
                          <div class="card-header text-center">
                            <span class="float-left">
                              <a href="{{ (url()->previous() == url()->current()) ? route('boards.show', $board) : url()->previous() }}">
                                <i class="gg-undo d-inline-block mr-1 text-dark"></i>
                              </a>
                            </span>
                            <div class="h4 d-inline-block mb-0 justify-content-center">
                                      {{ $thread->likes->count() }}
                                        {{ Str::plural('like', $thread->likes->count()) }} 
                                            <i class="gg-heart text-danger mb-2 d-inline-block mr-1"></i>
                                            / 
                                            <i class="gg-comment d-inline-block mr-1 mb-1"></i>{{ $thread->replies->count() }}
                                            {{ Str::plural('reply', $thread->replies->count()) }}
                                            <small class="text-muted">last updated: {{ $thread->updated_at->diffForHumans() }}</small>
                                        </div>
                            <span class="float-right mt-2">
                            <i class="gg-anchor"></i>
                            </span>
                          </div>
                          <div class="card-body">
                              <div class="media border bg-light mb-2 pt-2">
                                @if ($thread->image)
                                <div class="d-flex flex-column">
                                  <div>
                                    <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $thread->id .'/'. $thread->image->name .'.'. $thread->image->type) }}">
                                      <figcaption class="figure-caption ml-1 mt-1 text-truncate" style="max-width: 200px;">{{ $thread->image->name }}</figcaption>
                                    </a>
                                    </div>
                                  <div>
                                    <img class="p-1" src="{{ asset('storage/'. $thread->image->thumbnail_path) }}" 
                                    alt="Generic placeholder image" style="max-height: 200px; max-width:200px">
                                  </div>
                                </div>
                                  @endif
                                <div class="media-body ml-2">
                                  @auth
                                  <span class="float-right shadow-sm p-1 bg-white rounded">
                                    @if ($thread->user->id != auth()->user()->id) {{--TODO: poner esto en todos los sitios, o dejarlo solo aqui... --}}
                                    <span class="text-muted">id:</span><a href="{{ route('users.show',$thread->user->username) }}" class="text-dark">{{ $thread->user->username }}</a>
                                    /
                                    @endif
                                    <small class="text-muted">
                                      {{$thread->created_at->toDateTimeString() }} ({{ $thread->created_at->isToday() ? 'Today' : $thread->created_at->shortEnglishDayOfWeek }})
                                    </small>
                                    @can('delete', $thread)
                                    <form action="{{ route('boards.threads.destroy', [$thread->board, $thread]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                          <i class="gg-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('boards.threads.edit', [$thread->board, $thread]) }}"
                                      method="get">
                                      @csrf
                                      <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                        <i class="gg-pen mt-1"></i>
                                      </button>
                                  </form>
                                    <form action="{{ route('boards.threads.up', [$thread->board, $thread]) }}"
                                      method="post">
                                      @csrf
                                      <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                        <span class="align-text-middle">Up!</span>
                                      </button>
                                  </form>
                                @endcan
                                  </span>
                                @endauth
                                @guest
                                <span class="float-right shadow p-1 bg-white rounded">{{ 'Anonymous' }}</span>
                                @endguest
                                <span class="d-block mt-1 pb-2">
                                  <span class="border-bottom mb-4 pb-1">
                                <h4 class="d-inline-block mb-0">
                                    <a href="{{ route('boards.threads.show',[$thread->board, $thread]) }}">
                                    {{ $thread->title }} 
                                  </a>
                                  @auth
                                  <span class="small font-weight-normal align-top">
                                    <a class="badge {{ ($thread->user->id == auth()->user()->id) ? 'badge-primary' : 'badge-secondary' }} mt-1 pt-1" href="#">
                                        {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                    </a>
                                  </span>
                                  @endauth
                                  <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                              </h4>
                                              <small class="text-muted">last updated: {{ $thread->updated_at->diffForHumans() }}</small>
                                            </span>
                                            </span>
                                <p class="h5 mt-2 ml-2">{{ $thread->body }}</p>
                                <div class="m-2">
                                  <i class="gg-info d-inline-block mr-2 align-middle"></i>
                                  <i class="gg-add d-inline-block mr-2 align-middle"></i>
                                  <i class="gg-bell d-inline-block mr-2"></i>
                                  {{-- <i class="gg-math-plus d-inline-block mr-2 align-middle"></i> --}}
                                  @if (!$thread->likedBy(auth()->user()))
                                  <form action="{{ route('threads.likes', $thread) }}" method="post" class="d-inline-block">
                                      @csrf
                                      <button type="submit" class="bg-danger" style="border:none;"><i class="gg-heart"></i></button>
                                  </form>
                              @else
                                  <form action="{{ route('threads.likes', $thread) }}" method="post" class="d-inline-block">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" style="border:none;" class="bg-light align-middle"><i class="gg-backspace"></i></button>
                                  </form>
                              @endif
                              <div class="btn-group float-right">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Order replies by:
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="#">+1's</a>
                                  <a class="dropdown-item" href="#">Mentions</a>
                                  <a class="dropdown-item" href="#">Sexinest of author</a>
                                </div>
                              </div>
                            </div>
                                  @forelse ($thread->replies as $reply)
                                  <div class="media m-3 border border-secondary">
                                    @if ($reply->image)
                                    <div class="d-flex flex-column">
                                      <div>
                                        <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $reply->thread->id .'/'. $reply->image->name .'.'. $reply->image->type) }}">
                                          <figcaption class="figure-caption ml-1 mt-1 text-truncate" style="max-width: 200px;">{{ $reply->image->name }}</figcaption>
                                        </a>
                                        </div>
                                      <div>
                                        <img class="p-1" src="{{ asset('storage/'. $reply->image->thumbnail_path) }}" 
                                        alt="Generic placeholder image" style="max-height: 200px; max-width:200px">
                                      </div>
                                    </div>
                                    @endif
                                    <div class="media-body ml-2">
                                          <div class="mb-2 pb-1 mt-1">
                                        @auth
                                        <span class="h6 float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                                          @if ($reply->user->id != auth()->user()->id) {{--TODO: poner esto en todos los sitios, o dejarlo solo aqui... --}}
                                          <span class="text-muted">id:</span><a href="{{ route('users.show',$reply->user->username) }}" class="text-dark">{{ $reply->user->username }}</a>
                                          /
                                          @endif
                                          <small class="text-muted">
                                            {{ $reply->created_at->toDateTimeString() . ' (' . $reply->created_at->shortEnglishDayOfWeek . ') ' }}
                                          </small>
                                          @can('delete', $reply)
                                          <form action="{{ route('threads.replies.destroy', [$reply->thread, $reply]) }}"
                                              method="post">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                                <i class="gg-trash"></i>
                                              </button>
                                          </form>
                                          @endcan
                                        </span>
                                        @endauth
                                        @guest
                                        <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">{{ 'Anonymus' }}</span>
                                        @endguest
                                         <span class="h5">Id.</span>  {{-- TODO: Poner que se pueda citar al OP...joder--}}
                                         @auth
                                        <span class="h5">
                                          <a class="badge {{ ($reply->user->id == auth()->user()->id) ? 'badge-primary' : 'badge-secondary' }} pt-1 mb-2" href="#">
                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                          </a>
                                        </span>
                                        @endauth
                                        {{-- TODO: todo esto, ofc --}}
                                        <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                        <span class="h6 align-text-middle">
                                                          {{-- <a class="badge badge-secondary mt-1 pt-1" href="#">
                                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                                          </a>  
                                                          Testeado y funciona bbien
                                                          --}}
                                                        </span>
                                                      </div>
                                                      <div class="col-8">
                                                        <hr class="my-0">
                                                      </div>

                                       <p class="h5 ml-2 mt-2">{{ $reply->body }}</p>  {{-- Cambiar tipografia --}}
                                      <div class="m-1 border text-right">
                                        <i class="gg-info d-inline-block mr-2 align-middle"></i>
                                        <i class="gg-add d-inline-block mr-2 align-middle"></i>
                                        <i class="gg-bell d-inline-block mr-2"></i>
                                        <i class="gg-math-plus d-inline-block mr-2 align-middle"></i>
                                        {{-- <i class="gg-heart d-inline-block mr-2"></i> --}}
                                      </div>
                                    </div>
                                  </div>
                                  @empty
                                      <h5>No replies</h5>
                                  @endforelse
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              @auth
              <div class="row">
                <div class="col">
                    <div class="text-center mb-2">
                            @if (!$thread->likedBy(auth()->user()))
                                <form action="{{ route('threads.likes', $thread) }}" method="post" class="mr-1 d-inline-block">
                                    @csrf
                                    <button type="submit" class="bg-danger" style="border:none; width:30px"><i class="gg-heart text-center"></i></button>
                                </form>
                            @else
                                <form action="{{ route('threads.likes', $thread) }}" method="post" class="mr-1 d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:none;" class="bg-light"><i class="gg-backspace"></i></button>
                                </form>
                            @endif
                            <i class="gg-comment d-inline-block ml-4 mb-1 align-text-bottom"></i>
                        <h5>{{ $thread->likes->count() }} {{ Str::plural('like', $thread->likes->count()) }} - {{ $thread->replies->count() }} {{ Str::plural('reply', $thread->replies->count()) }}</h5>
                    </div>
                </div>
            </div>
              <div class="row">
                  <div class="col-10 m-auto ">
                    <div class="card">
                      <div class="card-header text-center">
                        <span class="h3">[ Post a Reply ]</span>
                      </div>
                      <div class="card-body">
                        <form action="{{ route('threads.replies.store', $thread) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                            <label for="InputTitle">User reply</label>
                            <input type="text" class="form-control" placeholder="{{ auth()->user()->username }}" readonly>
                            <small id="readonlyHelp" class="form-text text-muted">User registered.</small>
                          </div>
                          <div class="form-group">
                            <label for="FormControlTextarea">Text reply</label>
                            <textarea class="form-control" id="FormControlTextarea" name="body" rows="5"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="FormControlFile">Image reply</label>
                            <input type="file" class="form-control-file" id="FormControlFile" name="reply_file">
                          </div>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="Check" name="reply_check">
                            <label class="form-check-label" for="Check">Check me out</label>
                          </div>
                          <button id='postSubmit' type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">Post</button>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>
              @endauth
        </div>
    </div>
</div>
@endsection
