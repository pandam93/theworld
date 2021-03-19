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
                          <div class="card-header">
                            <a href="{{ (url()->previous() == url()->current()) ? route('boards.show', $board) : url()->previous() }}">
                              <i class="gg-undo d-inline-block mr-1 text-dark"></i>
                            </a>
                            {{ $thread->title }}
                            <span class="float-right mt-2">
                            <i class="gg-anchor"></i>
                            </span>
                          </div>
                          <div class="card-body">
                              <div class="media border bg-light mb-2">
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
                                    <span class="text-muted">id:</span><a href="{{ route('users.show',$thread->user->username) }}" class="text-dark">{{ $thread->user->username}}</a>
                                    <small class="text-muted">
                                      /
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
                                    <form action="{{ route('boards.threads.destroy', [$thread->board, $thread]) }}"
                                      method="post">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="text-secondary float-right bg-light" style="border:none;">
                                        <i class="gg-pen mt-1"></i>
                                      </button>
                                  </form>
                                    <form action="{{ route('boards.threads.destroy', [$thread->board, $thread]) }}"
                                      method="post">
                                      @csrf
                                      @method('DELETE')
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
                                <h4>
                                  {{-- <a href="{{ route('boards.threads.show',[$board, $thread]) }}"> --}}
                                  {{ $thread->title }}
                                {{-- </a> --}}
                                <span class="small font-weight-normal align-top">
                                  <a class="badge badge-secondary mt-1 pt-1" href="#">
                                      {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                                  </a>
                                </span>
                                </h4>
                                <p class="mt-4 ml-2">{{ $thread->body }}</p>
                                <div class="m-1 border">
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
                              <span>{{ $thread->likes->count() }} {{ Str::plural('like', $thread->likes->count()) }}</span>
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
                                    <div class="d-flex-in flex-column">
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
                                      @auth
                                      <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                                        <span class="text-muted">id:</span><a href="{{ route('users.show', $reply->user->username) }}" class="text-dark">{{ $reply->user->username }}</a>
                                        /
                                        <small class="text-muted">
                                          {{ $reply->created_at->toDateTimeString() . ' (' . $reply->created_at->shortEnglishDayOfWeek . ') ' }}
                                        </small>
                                      </span>
                                      @endauth
                                      @guest
                                      <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">{{ 'Anonymus' }}</span>
                                      @endguest
                                      <span class="d-block mt-1 pb-2">
                                        <span class="border-bottom mb-4 pb-1">
                                      <h5 class="d-inline-block mb-0">
                                        id:
                                        <span class="font-weight-normal align-top">
                                          <a class="badge badge-secondary mt-1 pt-1" href="#">
                                              {{ str_pad($reply->id, 7, '0', STR_PAD_LEFT) }}
                                          </a>
                                        </span>
                                        {{-- TODO: todo esto, ofc --}}
                                        <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                                        <span class="small font-weight-normal align-text-top">
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
                                      <p class="mt-4 ml-2">{{ $reply->body }}</p>
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
                                <form action="{{ route('threads.likes', $thread) }}" method="post" class="mr-1">
                                    @csrf
                                    <button type="submit" class="bg-danger" style="border:none; width:30px"><i class="gg-heart text-center"></i></button>
                                </form>
                            @else
                                <form action="{{ route('threads.likes', $thread) }}" method="post" class="mr-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border:none;" class="bg-light"><i class="gg-backspace"></i></button>
                                </form>
                            @endif                
                        <h5>{{ $thread->likes->count() }} {{ Str::plural('like', $thread->likes->count()) }}</h5>
                    </div>
                </div>
            </div>
              <div class="row">
                  <div class="col-10 m-auto ">


                    {{--<div class="text-center">
                      <div class="collapse-trigger pb-2">
                          <a href="" data-toggle="collapse" data-target="#createReply" aria-expanded="false"
                              aria-controls="createReply">
                              <span class="h3">[ Post a Reply ]</span>
                          </a>
                      </div>

                     <div class="collapse card @if ($errors->any()) {{ 'show' }} @endif" id="createReply">
                      <div class="card-body justify-content-start">
                          <form method="POST" action="{{ route('threads.replies.store', [$thread]) }}"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="form-group row">
                              <label for="inputTitle" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="text"
                                      placeholder="{{ Auth::user()->name }}" readonly>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="TextareaText"
                                  class="col-sm-2 col-form-label my-auto">Text</label>
                              <div class="col-sm-10">
                                  <textarea class="form-control @error('body') is-invalid @enderror" id="TextareaText" rows="5"
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
                                  <input type="file" class="form-control-file @error('reply_file') is-invalid @enderror" id="FileImage"
                                      name="reply_file">
                                      <div class="invalid-feedback text-left">
                                          @error('reply_file')
                                          · {{ $message }}
                                          @enderror
                                          </div>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="InputUrl" class="col-sm-2 col-form-label">URL</label>
                              <div class="col-sm-10">
                                  <input type="url" class="form-control @error('url') is-invalid @enderror" id="InputUrl" name="url"
                                      placeholder="url" {{ old('url') }}>
                                      <div class="invalid-feedback text-left">
                                      @error('url')
                                      · {{ $message }}
                                      @enderror
                                      </div>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary">Post</button>
                          </form>
                      </div>
                  </div> --}}


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
