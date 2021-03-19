@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
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
                        <img src="{{ asset('img/banner.jpg') }}" class="img-fluid" alt="Responsive image" style="max-width: 50%">
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
                                      <label for="TextareaText" class="col-sm-2 col-form-label my-auto">Text</label>
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
                    <div class="media mb-2 bg-light">
                      @if ($thread->image)
                      <div class="d-flex flex-column">
                        <div>
                          <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $thread->id .'/'. $thread->image->name .'.'. $thread->image->type) }}">
                            <figcaption class="figure-caption ml-1 mt-2 text-truncate" style="max-width: 200px;">{{ $thread->image->name }}</figcaption>
                          </a>
                          </div>
                        <div>
                          <img class="p-1" src="{{ asset('storage/'. $thread->image->thumbnail_path) }}" 
                          alt="image404" style="max-height: 200px; max-width:200px">
                        </div>
                      </div>
                        @endif
                      <div class="media-body ml-2">
                        @auth
                          <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                            <span class="text-muted">id:</span><a href="{{ route('users.show',$thread->user->username) }}" class="text-dark">{{ $thread->user->username }}</a><small class="text-muted">{{ $thread->created_at->toDateTimeString() }} ({{ $thread->created_at->isToday() ? 'Today' : $thread->created_at->shortEnglishDayOfWeek }})</small>
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
                          </a>
                          <span class="small font-weight-normal align-top">
                            <a class="badge badge-secondary mt-1 pt-1" href="#">
                                {{ str_pad($thread->id, 7, '0', STR_PAD_LEFT) }}
                            </a>
                          </span>
                          <i class="gg-more-vertical-alt d-inline-block m-1"></i>
                                      </h4>
                                      <small class="text-muted">last updated: {{ $thread->updated_at->diffForHumans() }}</small>
                                    </span>
                                    </span>
                        {{ $thread->body }}
                        @forelse ($thread->preReplies->reverse() as $reply)
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
                            @auth
                            <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">
                              <span class="text-muted">id:</span><a href="{{ route('users.show',$reply->user->username) }}" class="text-dark">{{ $reply->user->username }}</a> <small class="text-muted"> {{ $reply->created_at->diffForHumans() }}</small>
                            </span>
                          @endauth
                          @guest
                          <span class="float-right shadow-sm p-1 ml-1 mb-1 bg-white rounded">{{ 'Anonymus' }}</span>
                          @endguest
                            <p class="mt-4 ml-2">{{ $reply->body }}</p>
                          </div>
                        </div>
                        @empty
                            <h5>No replies</h5>
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

{{-- TODO: Hacer obligatorio subir cada hilo con una imagen.

  
   <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $thread->id .'/'. $thread->image->name .'.'. $thread->image->type) }}">
  <figcaption class="figure-caption ml-1">{{ Str::limit($thread->image->name, 10, '...') }}</figcaption>
</a>

<span class="d-inline-block text-truncate" style="max-width: 150px;">
  Praeterea iter est quasdam res quas ex communi.
</span>

--}}