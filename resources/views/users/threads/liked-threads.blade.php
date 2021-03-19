@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <div class="p-6">
                            <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">

                        <div class="card">
                            <div class="card-header">
                                Threads Liked
                            </div>
                            <div class="card-body">
                                @forelse ($threadsLikes as $thread)
                                    <div class="media">
                                        @if ($thread->image)
                                        <a target="_blank" href="{{ asset('storage/threads/'. $board->name .'/'. $thread->id .'/'. $thread->image->name .'.'. $thread->image->type) }}">
                                          <img class="mr-3 p-1" src="{{ asset('storage/'. $thread->image->thumbnail_path) }}" 
                                          alt="Generic placeholder image" style="max-height: 200px; max-width:200px">
                                        </a>
                                        @endif
                                        <div class="media-body">
                                            <h5 class="mt-0"> <a
                                                    href="{{ route('boards.threads.show', [$thread->board, $thread]) }}"
                                                    class="font-bold">
                                                    {{ $thread->thread_title }}
                                                </a>
                                                <span class="text-gray-600 text-sm">
                                                    {{ $thread->created_at->diffForHumans() }}
                                                </span>
                                            </h5>
                                            @can('delete', $thread)
                                                <form action="{{ route('boards.threads.destroy', [$thread->board, $thread]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-danger mb-1">Delete</button>
                                                </form>
                                            @endcan

                                            <div class="mb-2">
                                                <h5>{{ $thread->likes->count() }}
                                                    {{ Str::plural('like', $thread->likes->count()) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <blockquote class="blockquote mb-0">
                                        <p>Los que no likean hilos son tremendos putos.
                                        </p>
                                        <footer class="blockquote-footer">Lo eres? <cite title="Source Title">Seguro que si</cite></footer>
                                    </blockquote>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
