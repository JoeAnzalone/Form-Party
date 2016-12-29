@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h2>Your {{ str_plural('Invite', count($invites)) }}</h2>

                    @if (count($invites))
                        <ul>
                        @foreach ($invites as $invite)
                            <li class="{{ $invite->claimed_by ? 'claimed' : 'unclaimed' }}"><a href="{{ $invite->url }}">{{ $invite->url }}</a></li>
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
