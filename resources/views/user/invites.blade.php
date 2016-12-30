@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invite</div>
                <div class="panel-body">
                    <h2>Your Invite Codes</h2>
                    <p>{{ config('app.name') }} is currently in beta, so new users will need an invite code to sign up.</p>


                    @if (count($invites->where('claimed_by_id', null)))
                        <p>Luckily for your friends, you just happen to have <em>{{ count($invites->where('claimed_by_id', null)) }}</em> unused {{ str_plural('code', count($invites->where('claimed_by_id', null))) }} right here!</p>
                        <p>Each invite code can only be used once, so make sure the recipient is worthy! 😉</p>
                    @else
                        <p>Unfortunately all your invite codes have been used up :(</p>
                    @endif

                    <ul>
                    @foreach ($invites as $invite)
                        <li>
                            <code><a class="{{ $invite->claimed_by ? 'claimed' : 'unclaimed' }}" href="{{ $invite->url }}">{{ $invite->code }}</a></code>
                            @if ($invite->claimed_by)
                            - claimed by <a href="{{ route('profile', $invite->claimed_by->username) }}">{{ $invite->claimed_by->username }}</a>
                            @endif
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection