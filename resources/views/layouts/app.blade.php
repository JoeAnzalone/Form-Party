<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title . ' :: ' : '' }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,600" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li {!! 'login' === Route::current()->getName() ? 'class="active"' : '' !!}><a href="{{ url('/login') }}">Login</a></li>
                            <li {!! 'register' === Route::current()->getName() ? 'class="active"' : '' !!}><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li {!! 'inbox' === Route::current()->getName() ? 'class="active"' : '' !!}><a href="{{ route('inbox') }}">Inbox
                            @if (Auth::user()->unanswered_message_count) <span class="badge">{{ Auth::user()->unanswered_message_count }}</span> @endif
                            </a></li>
                            <li {!! !empty($user) && $user->username === Auth::user()->username && 'profile' === Route::current()->getName() ? 'class="active"' : '' !!}><a href="{{ route('profile', Auth::user()->username) }}">{{ Auth::user()->username }}</a></li>
                            @if (Auth::user()->has_invites && config('app.invite_only'))
                            <li {!! 'invite' === Route::current()->getName() ? 'class="active"' : '' !!}><a href="{{ route('invite') }}">Invite</a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if (!empty(\Session::get('success')))
            <div class="alert alert-success">
            {!! \Session::get('success') !!}
            </div>
        @endif

        @if (!empty(\Session::get('error')))
            <div class="alert alert-error">
            {!! \Session::get('error') !!}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
