@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        hola! Lo ideal seria, supongo, poder editarlo por medio de js y que sea asincrono...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection