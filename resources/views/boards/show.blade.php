@extends('layouts.app')

@section('content')
                {{-- INCLUDE HEADER --}}
                @include('layouts.board.header')
                <div class="card">
                    <div class="card-header">{{ $quote }}</div>
                    <div class="card-body">
                        @foreach ($threads as $thread)
                            <div class="row">
                                <div class="text-center px-2"> {{-- Poner un col aqui le pone demasiado padding a los likes :/ Y encima hace que se desperdicie espacio a la derecha, me cago en todo --}}
                                    @include('layouts.board.votes')
                                </div>

                                <div class="col-11">
                                    @include('layouts.thread.OP')
                                    {{-- TODO: ver si se puede mejorar esto --}}
                                    @forelse ($thread->replies()->take(3)->get(); as $reply)
                                        @include('layouts.thread.reply')
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
