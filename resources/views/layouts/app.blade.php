<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title . ' :: ' : '' }}{{ config('app.name', 'Laravel') }} 🎉</title>
    @if (!empty($og))
        @foreach ($og as $key => $value)
            <meta property="{{ $key }}" content="{{ $value }}">
        @endforeach
    @endif

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body data-page="{{ $page or 'default' }}" class="page-{{ $page or 'default' }}">
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
                        @if (Auth::user() && Auth::user()->unanswered_message_count)
                            <span class="badge hamburger-menu-badge">{{ Auth::user()->unanswered_message_count }}</span>
                        @endif
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                         🎉 {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li {!! Route::is('login') ? 'class="active"' : '' !!}><a href="{{ url('/login') }}">Login</a></li>

                            @if (!config('app.invite_only'))
                                <li {!! Route::is('register') ? 'class="active"' : '' !!}><a href="{{ url('/register') }}">Register</a></li>
                            @endif
                        @else
                            <li {!! Route::is('dashboard') ? 'class="active"' : '' !!}><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li {!! Route::is('inbox') || Route::is('message.viewArchive') ? 'class="active"' : '' !!}><a href="{{ route('inbox') }}">Inbox
                            @if (Auth::user()->unanswered_message_count) <span class="badge">{{ Auth::user()->unanswered_message_count }}</span> @endif
                            </a></li>
                            <li {!! !empty($user) && $user->username === Auth::user()->username && Route::is('profile') ? 'class="active"' : '' !!}>
                                <a href="{{ route('profile', Auth::user()) }}">
                                    {{ Auth::user()->username }} {!! Auth::user()->avatarImg(200, 20, false) !!}
                                </a>
                            </li>
                            @if (Auth::user()->has_invites && config('app.invite_only'))
                            <li {!! Route::is('invite') ? 'class="active"' : '' !!}><a href="{{ route('invite') }}">Invite</a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @if (!empty(\Session::get('success')) || !empty($success))
            <div class="alert alert-success">
            {!! \Session::get('success') ?: $success !!}
            </div>
        @endif

        @if (!empty(\Session::get('info')) || !empty($info))
            <div class="alert alert-info">
            {!! \Session::get('info') ?: $info !!}
            </div>
        @endif

        @if (!empty(\Session::get('error')) || !empty($error))
            <div class="alert alert-danger">
            {!! \Session::get('error') ?: $error !!}
            </div>
        @endif

        @yield('content')
    </div>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>

    @if (View::exists('analytics'))
        @include('analytics')
    @endif
</body>
</html>
