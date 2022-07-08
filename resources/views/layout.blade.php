<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Descrição de Posições | {{ config('app.name', 'Thutor') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type='text/javascript'>
        // Smartlook
        window.smartlook||(function(d) {
          var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
          var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
          c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
          })(document);
          smartlook('init', '8f66c385106835c4f410b46f3d02b281d9eb14bd');
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7ec8c4369c.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Arial', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .navbar-light .navbar-nav .nav-link.featured {
            color: #fff;
            background-color: #3490dc;
            border-radius: 3px;
        }
    
        .full-height { height: 100vh; }
    
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
    
        .position-ref { position: relative; }
    
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
    
        .top-left {
            position: absolute;
            left: 10px;
            top: 18px;
        }
    
        .content { text-align: center; }
    
        .title { font-size: 84px; }
    
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    
        .m-b-md { margin-bottom: 30px; }
    
        .logoth { width: 250px; }

        .autocomplete-items {
          position: absolute;
          background-color: white;
          border: 1px solid gray;
          padding: 10px;
          z-index: 99;
          top: 100%;
          width: 100%;
          cursor: pointer;
        }
      
        .targetgroup {
          background-color: #f2f2f2;
          padding: 10px;
          border-radius: 5px 5px 0px 0px;
        }
      
        .wrapperactivity {
          background-color: #fbfbfb;
          border-radius: 0px 0px 5px 5px;
        }
      
        .canvas {
          position: fixed;
          top: 0;
          left: 0;
          z-index: 9999;
      
          display: none;
          width: 100vw;
          height: 100vh;
          background-color: rgba(168, 168, 168, 0.5);
      
          align-items: center;
          justify-content: center;
        }
      
        .canvas.active { display: flex }
      
        textarea { min-height: 40px; }

        .read_position_form .form-control {
            height: auto;
            min-height: calc(1.6em + .75rem + 2px);
        }

        .read_position_form .targetgroup { background-color: rgba(0, 0, 0, 0) }

        .classification__container {
            margin-top: 2.5px;
            flex:0 0 auto;
            display:flex;
            width:20px;
            height:20px;
            border:1px solid #ccc;
            align-items: center;
            justify-content: center;
        }

        .classification__container + span {
            display:block;
            margin-left:10px
        }

        .restrictions__container {
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
        }

        .sign__container {
            margin-top: 100px;

            display: none;
            border-top: 1px solid #dee2e6;
            padding-top: 50px;
        }

        .js-interest-group {
            display: grid;
            grid-template-areas: "field";
        }

        .js-interest-field {
            grid-area: field;
            visibility: hidden;
        }

        textarea.terms_and_privacy {
            resize: none;
            height: 300px;
        }

        @media print {
            .navbar { display: block !important }
            .navbar ul.navbar-nav { display: none !important; }
            .shadow-sm { box-shadow: none !important }
            .sign__container {
                display: block;
                page-break-inside: avoid;
            }

            .print__break-line { page-break-before: always }
        }
      </style>
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                {{-- Brand Name --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img
                        class="logoth"
                        src="{{ url('/images/logoth.png') }}"
                        alt="{{ config('app.name', 'Thutor') }}"
                        style="width:auto;height:30px;">
                </a>

                @auth
                
                {{-- Mobile button --}}
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">

                    <span class="navbar-toggler-icon"></span>

                </button>

                {{-- Top menu --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-toggle="dropdown"
                                href="#" 
                                role="button"
                                aria-haspopup="true"
                                aria-expanded="false">Relatórios</a>
                            <div class="dropdown-menu">
                                <a
                                    class="nav-link"
                                    href="{{ route('reportListPositionDescription', [ 'interviewed' => 'leader' ]) }}"
                                >{{ __('Descrição de Posição') }}</a>

                                <a
                                    class="nav-link"
                                    href="{{ route('listPositionInterest') }}"
                                >{{ __('Demonstração de Interesse') }}</a>

                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-toggle="dropdown"
                                href="#" 
                                role="button"
                                aria-haspopup="true"
                                aria-expanded="false">Competências</a>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="{{ route('listCompetenceType') }}">{{ __('Tipo') }}</a>
                                <a class="nav-link" href="{{ route('listCompetenceLevel') }}">{{ __('Nível') }}</a>
                                <a class="nav-link" href="{{ route('listCompetence') }}">{{ __('Competência') }}</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-toggle="dropdown"
                                href="#" 
                                role="button"
                                aria-haspopup="true"
                                aria-expanded="false">Curso</a>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="{{ route('listGrade') }}">{{ __('Grau') }}</a>
                                <a class="nav-link" href="{{ route('listArea') }}">{{ __('Área') }}</a>
                                <a class="nav-link" href="{{ route('listGradeCourse') }}">{{ __('Curso') }}</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('listLanguage') }}">{{ __('Idioma') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>
                        
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-toggle="dropdown"
                                href="#" 
                                role="button"
                                aria-haspopup="true"
                                aria-expanded="false">Posição</a>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="{{ route('listPosition') }}">{{ __('Posição') }}</a>
                                <a class="nav-link" href="{{ route('listPositionGroup') }}">{{ __('Grupo da Posição') }}</a>
                                <a class="nav-link" href="{{ route('listDirectorate') }}">{{ __('Diretoria') }}</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>

                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                data-toggle="dropdown"
                                href="#" 
                                role="button"
                                aria-haspopup="true"
                                aria-expanded="false">Configurações</a>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="{{ route('listUserRoles') }}">{{ __('Permissões') }}</a>
                                <a class="nav-link" href="{{ route('listUser') }}">{{ __('Usuários') }}</a>
                                <a class="nav-link" href="{{ route('editConfig') }}">{{ __('Parâmetros') }}</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">|</a></li>

                        <li class="nav-item">
                            <a class="nav-link featured" href="{{ route('listPositionDescription') }}">{{ __('Descrição de Posição') }}</a>
                        </li>
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                @auth
                                    <a class="nav-link" href="{{ url('/home') }}">{{ __('Home') }}</a>
                                @else
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endauth
                            </li>
                        @else
                            <li class="nav-item dropdown">

                                <a
                                    id="navbarDropdown"
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    v-pre>

                                    {{ Auth::user()->name }} <span class="caret"></span>

                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <a
                                        class="dropdown-item"
                                        href="{{ route( 'editUser', Auth::user()->id ) }}"
                                    >{{ __('Meu Perfil') }}</a>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    >{{ __('Sair') }}</a>

                                    <form
                                        id="logout-form"
                                        action="{{ route('logout') }}"
                                        method="POST"
                                        style="display: none;"
                                    >@csrf</form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>

                @endauth

            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
        
    </div>

    {{-- Smartlook User Data --}}
    @auth
    <script async defer>
        document.addEventListener('DOMContentLoaded', function () {
            (function () {
                var smart = window.smartlook;
                if (!smart) return;
                smart('identify', '{{ Auth::id() }}', {
                    'email': '{{ Auth::user()->email }}'
                })
            })()
        })
    </script>
    @endauth
</body>
</html>
