<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- https://fontawesome.com/v4.7.0/icons/ --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('boards.index') }}">
                                        {{ __('My Boards') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10">
                        @yield('content')
                    </div>
                    <div class="col-2">
                        @auth
                        <div class="card mb-3">
                            <div class="card-header">
                              #Staka Duggan
                            </div>
                            <table class="table mb-0">
                              <tbody>
                                <tr>
                                  <th scope="row">Panel de control
                                  </th>
                                <td><span class="pull-right mr-5"><a href="#">TI</a> <a href="#">TP</a></span></td>
                                </tr>
                                <tr>
                                  <th scope="row">Mensajes <span class="badge badge-info">0</span>
                                  </th>
                                  <td class="mt-2" rowspan="6"><img class="img-thumbnail" src="https://st.forocoches.com/foro/customavatars/avatar827591_1.gif" alt="" style="display:block; width:100%; height:auto;"></td>
                                </tr>
                                <tr>
                                  <th scope="row">Citas <span class="badge badge-info">0</span>
                                  </th>
                        
                                </tr>
                                <tr>
                                  <th scope="row">Menciones <span class="badge badge-info">{{ Auth::user()->unreadNotifications->count() }}</span>
                        </th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          @endauth
                        <div class="card">
                            <div class="card-header">Newest threads</div>
                            <div class="card-body">
                                @foreach ($newestThreads as $thread)
                                    <a href="{{ route('boards.threads.show',[$thread->board,$thread]) }}">
                                        {{ $thread->title }}
                                    </a>
                                    <a href="{{ route('boards.show',[$thread->board]) }}"> 
                                        (/{{ $thread->board->short_name }}/ - {{ $thread->board->name }})
                                    </a>
                                    <div class="mt-1">{{ $thread->created_at->diffForHumans() }}</div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">Lovest boards</div>
                            <div class="card-body">
                                @foreach ($fattestBoards as $board)
                                <a href="{{ route('boards.show',$board) }}">
                                {{ $board->name }}</a>
                                ({{ $board->threads_count }} threads)
                                <div class="mt-1">{{ $board->created_at->diffForHumans() }}</div>
                                <hr>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
