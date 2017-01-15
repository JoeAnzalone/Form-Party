@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if ($search_term)
                        Search: <b>{{ $search_term }}</b>
                    @else
                        Search
                    @endif
                </div>
                <div class="panel-body">
                    <form class="search-form form-inline" action="{{ route('search') }}" method="GET">
                        <input name="q" class="form-control" type="search" placeholder="Search" value="{{ $search_term }}">
                    </form>

                    @if ($search_term)

                        @if (count($results['users']))
                        <div class="panel panel-default">
                            <div class="panel-body">
                                    <ul class="users">
                                    @foreach ($results['users'] as $user)
                                        <li>
                                            {!! $user->avatarImg(200) !!}
                                            <div>
                                                <a class="username" href="{{ $user->url }}">{{ $user->username }}</a>
                                                <h4 class="name">{{ $user->name }}</h4>
                                            </div>
                                        </li>
                                    @endforeach
                                    </ul>
                            </div>
                        </div>
                        @endif

                        @if (count($results['messages']))
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @foreach ($results['messages'] as $message)
                                    @include('message.single')
                                @endforeach
                            </div>
                        </div>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
