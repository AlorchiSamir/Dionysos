<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{url('graphics/icon.jpg')}}" />

    <!-- Scripts -->
    <script src="{{ asset('js/dionysos.js') }}" defer></script>
    <script src="{{ asset('js/lightslider.js') }}" defer></script>
    <script src="{{ asset('plugins/lightbox/js/lightbox.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <!-- Styles -->
    <link href="{{ asset('css/dionysos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/lightbox/css/lightbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
</head>
<body>
    @include('cookieConsent::index')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm top-bar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class='logo' src="{{url('graphics/logo.jpg')}}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if(!is_null(Auth::user()) && Auth::user()->isAdmin())
                    <a class="nav-link" href="{{ url('/admin') }}">Administration</a>
                @elseif(!is_null(Auth::user()) && !Auth::user()->isProfessional())
                    <a class="nav-link" href="{{ url('/project') }}">Mes projets</a>
                @elseif(!is_null(Auth::user()) && Auth::user()->isProfessional() && Auth::user()->getProfessional()->isHallOwner())
                    <a class="nav-link" href="{{ url('/hall/owner-page') }}">Mes projets</a>
                @endif
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link auth" href="{{ route('login') }}">{{ __('login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link auth" href="{{ url('register?type=user') }}"><span>{{ __('create_account') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="create-pro" href="{{ url('register?type=pro') }}"><span>{{ __('become_pro') }}</span></a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('messages') }}">{{ __('messages') }}
                                @if(Auth::user()->getCountMessagesNotView() > 0)
                                    <span class='message-count'>({{ Auth::user()->getCountMessagesNotView() }})</span>
                                @endif
                                </a>
                            </li>
                            <li class="nav-item dropdown">                                
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(!is_null(Auth::user()) && !Auth::user()->isProfessional())
                                        <img class='avatar-round' src="{{  url('images/avatar/crop/'.Auth::user()->getSetting('avatar')) }}" />
                                    @else
                                        <img class='avatar-round' src="{{  url('images/avatar/crop/'.Auth::user()->getProfessional()->getSetting('avatar')) }}" />
                                    @endif                                    
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('interaction/interest') }}">{{ __('interests') }}</a>
                                    <a class="dropdown-item" href="{{ url('advice') }}">{{ __('advice') }}</a>
                                    <a class="dropdown-item" href="{{ url('settings') }}">{{ __('settings') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('logout') }}
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

        <main>
            @include('layouts.messages')
            <div class="container">
                <div class="alert alert-success alert-dismissible hidden">
                    {{ __('confirmation_message') }}
                </div>   
            </div>
            @yield('content')
            <div id="button-modal">{{ __('message') }}</div>
        </main>
        <footer id='footer-page'>
            <div class='container'>
                <div class='row'>
                <div class='col-md-3'>
                    <h3>A Propos</h3>
                    <ul>
                        <li>Politique de confidentialité</li>
                        <li>Politique des cookies</li>
                    </ul>
                </div>
                <div class='col-md-3'>
                    <h3>Utilisateurs</h3>
                    <ul>
                        <li>S'inscrire</li>
                    </ul>
                </div>
                <div class='col-md-3'>
                    <h3>Professionels</h3>
                    <ul>
                        <li>Devenir professionel</li>
                    </ul>
                </div>
                <div class='col-md-3'>
                    <h3>Contact</h3>
                </div>
            </div>
            </div>
        </footer>
        @include('messages.modals.admin')
        
    </div>
    <script>
  
    $(function(){
  
        $('#button-modal').click(function() {
            $('#message-modal-admin').modal();
        });
  
       $(document).on('submit', '#message-admin-form', function(e) {  
            e.preventDefault();
              
            $('input+small').text('');
            $('input').parent().removeClass('has-error');
              
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                //dataType: "json"
            })
            .done(function(data) {
                console.log(data);
                $('.alert-success').removeClass('hidden');
                $('#message-modal').modal('hide');
            })
            .fail(function(data) {
                console.log(data);
                $.each(data.responseJSON, function (key, value) {
                    var input = '#message-form input[name=' + key + ']';
                    $(input + '+small').text(value);
                    $(input).parent().addClass('has-error');
                });
            });
        });
  
    })
  
    </script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
            crossorigin=""></script>
</body>
</html>
