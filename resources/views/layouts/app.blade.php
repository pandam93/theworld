<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link href='https://css.gg/css' rel='stylesheet'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /*
 * Footer
 */
        .blog-footer {
            padding: 2.5rem 0;
            color: #999;
            text-align: center;
            background-color: #f9f9f9;
            border-top: .05rem solid #e5e5e5;
        }

        .blog-footer p:last-child {
            margin-bottom: 0;
        }

    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @foreach ($boards as $key => $name)
                            <li class="nav-item">
                                <a href="{{ route('boards.show', ['board' => $key]) }}"
                                    class="nav-link">{{ $name }}</a>
                            </li>
                        @endforeach
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->user()->username) }}">
                                        Perfil
                                    </a>

                                    <a class="dropdown-item"
                                        href="{{ route('users.threads.index', auth()->user()->username) }}">
                                        Mis threads
                                    </a>

                                    <a class="dropdown-item"
                                        href="{{ route('users.threads.liked', auth()->user()->username) }}">
                                        Mis liked threads
                                    </a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
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
            @yield('content')
        </main>
    </div>
    <footer class="blog-footer">
        <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a
                href="https://twitter.com/mdo">@mdo</a>.</p>
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        const p = document.querySelectorAll('.postText');
        const q = document.querySelectorAll('.quoteTag');

        p.forEach(item => {
            item.innerHTML = item.innerHTML.replace(/\B&gt;&gt;([\d]{7})/gm, (url) => '<a id="r' + item
                .id +
                '" href="#' + url
                .substring(8).replace(
                    /^0+/, '') + '"type="reply" onclick="MyFunction">' + url + '</a>');


            // Create anchor element. 
            var text = item.innerHTML.match(/\B&gt;&gt;([\d]{7})/gm)
            if (text !== null) {
                // Create anchor element. 
                var a = document.createElement('a');
                var t = text[0].substring(8).replace(
                    /^0+/, '');

                if (t !== '') {
                    // Create the text node for anchor element. 
                    var link = document.createTextNode(' >>' + item.id.substr(1).padStart(7, "0"));

                    // Append the text node to anchor element. 
                    a.appendChild(link);

                    // Set the title. 
                    //a.title = "This is Link";

                    // Set the href property. 
                    a.href = "#" + item.id;

                    a.addEventListener('click', MyFunction);

                    //TODO: bonito intento pero no merece la pena el tiempo y sufrimiento que le voy a dar a esto
                    //me doy por satisfecho por haber hecho los links de respuestas dinamicos. Ojala alguien me ayude
                    //con esto...
                    // var div = document.getElementById(item.id);
                    // var preview = div.cloneNode(true);
                    // console.log(preview);
                    // preview.style.position = 'absolute'
                    // preview.style.top = '-5px'
                    // preview.style.left = '0'
                    // preview.style.width = '100%'
                    // preview.style.display = 'block';
                    // preview.zIndex = '1000'
                    // a.addEventListener('mouseover', (e) => e.target.appendChild(preview))

                    var h = document.getElementById('rh' + t);
                    if (h) {
                        h.appendChild(a);
                    }
                }
            }


        });

        q.forEach(item => {
            item.addEventListener('click', (e) => {
                var formReply = document.getElementById('FormControlTextarea');
                formReply.innerHTML += '>>' + e.target.innerText + '\n';
            })
        })

        function MyFunction(e) {
            var preselected = document.querySelector('.bg-success');
            if (preselected !== null && preselected !== '') {
                preselected.classList.remove('bg-success')
            }
            var focushin = document.getElementById(e.target.attributes.href.textContent.substring(1));
            //console.log(e.target.attributes.href.textContent.substring(1));
            if (focushin !== null && focushin !== '') {
                focushin.classList.add('bg-success')
            }
        }

        document.querySelectorAll('a[type="reply"]').forEach(item => {
            item.addEventListener('click', MyFunction)
            item.addEventListener('mouseover', (e) => {
                document.getElementById(e.target.attributes.href.textContent.substring(1)).classList
                    .add('bg-success');
            })
            //Curioso esto TODO:
            // item.addEventListener('mouseout', (e) => {
            //     document.getElementById(e.target.attributes.href.textContent.substring(1)).classList
            //         .remove('bg-success');
            // })

        });

    </script>
</body>

</html>
