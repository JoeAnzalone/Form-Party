@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Your Messages</h2>

                    @if (count($messages))
                        @include('message.index', ['messages' => $messages])
                    @else
                        <p>You have no messages</p>
                    @endif

                    <h2>Your {{ str_plural('Invite', count($invites)) }}</h2>

                    @if (count($invites))
                        <ul>
                        @foreach ($invites as $invite)
                            <li>
                                <a class="{{ $invite->claimed_by ? 'claimed' : 'unclaimed' }}" href="{{ $invite->url }}">{{ $invite->url }}</a>
                                @if ($invite->claimed_by)
                                - claimed by <a href="{{ route('profile', $invite->claimed_by->username) }}">{{ $invite->claimed_by->username }}</a>
                                @endif
                            </li>
                        @endforeach
                        </ul>
                    @else
                        <p>You have no invites</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
