<div class="row py-4">
    <div class="col">
        <div class="container">
            <div class="text-center">
                <div class="collapse-trigger pb-2">
                    {{-- Title board --}}
                    <h3>{{ '/' . $board->short_name . '/ - ' . $board->name }}</h3>
                    <hr>
                    {{-- Description of board --}}
                    <p>{{ $board->description ?? 'Aqui deberia haber una descripcion del board' }}</p>
                    {{-- Button to trigger the create form board --}}
                    <a href="" data-toggle="collapse" data-target="#createReply" aria-expanded="false"
                        aria-controls="createReply">
                        <span class="h3">[ Post a Reply ]</span>
                    </a>
                </div>
                <div class="col-8 mx-auto">
                    <div class="collapse card @if ($errors->any()) {{ 'show' }} @endif" id="createReply">
                        <div class="card-body justify-content-start">
                            @include('layouts.forms.create-reply')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
