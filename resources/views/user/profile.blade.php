@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body media user-info">
                    <div class="media-left">
                        <img class="user-avatar" src="{{ $user->avatar(200) }}" width="100" title="{{ $user->username_possessive }} avatar" alt="{{ $user->username_possessive }} avatar">
                        @can('follow', $user)
                            @include('user.follow_button')
                        @endcan

                        @can('unfollow', $user)
                            @include('user.unfollow_button')
                        @endcan
                    </div>
                    <div class="media-body">
                        <h3 class="user-username">{{ $user->username }}</h3>
                        @if ($user->website) <span class="separator">❥</span> <a class="user-website" target="_blank" href="{{ $user->website }}">{{ $user->short_website }}</a> @endif
                        <div class="user-joined">Partying since {{ $user->created_at->format('F Y') }}</div>
                        <div class="user-bio">{!! nl2br(e($user->bio)) !!}</div>
                    </div>

                    @if ($user->following->count())
                    <div class="following">
                        <h5>Following</h5>
                        @include('user.index', ['users' => $user->following, 'show_usernames' => false])
                    </div>
                    @endif

                    @if (Auth::user() && $user->is(Auth::user())) <a class="edit-user text-center" href="{{ route('settings') }}">Edit profile</a> @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Send an anonymous message to {{ $user->username }}
                </div>

                <div class="panel-body">
                    @include('user.form', ['user' => $user])
                </div>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->username_possessive }} Messages
                </div>

                <div class="panel-body">
                    @if (count($messages))
                        @foreach ($messages as $message)
                            @include('message.single')
                        @endforeach

                        <div class="pagination-wrapper">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <p>{{ $user->username }} doesn't have any messages yet. Why not make their day by <a href="#" data-js-focus-message-box>sending one</a>? 👆</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
