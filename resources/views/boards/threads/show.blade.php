@extends('layouts.app')

@section('content')
                    {{-- INCLUDE HEADER --}}
                    @include('layouts.thread.header')
                    <div class="card">
                        <div class="card-header">texto de mierda</div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="text-center px-2"> {{-- Poner un col aqui le pone demasiado padding a los likes :/ Y encima hace que se desperdicie espacio a la derecha, me cago en todo --}}
                                        @include('layouts.board.votes')
                                    </div>
    
                                    <div class="col-11">
                                        @include('layouts.thread.OP')
                                        {{-- TODO: ver si se puede mejorar esto --}}
                                        @forelse ($thread->replies()->get()->sortBy('created_at') as $reply)
                                            @include('layouts.thread.reply')
                                        @empty
                                            <span class="h5 text-muted">No replies yet</span>
                            @endforelse
                        </div>
                    </div>
                    <hr />
                </div>
            </div>
@endsection