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
                    <a href="" data-toggle="collapse" data-target="#createThread" aria-expanded="false"
                        aria-controls="createThread">
                        <span class="h3">[ Create a Thread ]</span>
                    </a>
                </div>
                <div class="col-8 mx-auto">
                    <div class="collapse card" id="createThread">
                        <div class="card-body justify-content-start">
                            @include('layouts.forms.create-thread')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
