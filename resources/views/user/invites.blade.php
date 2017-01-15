@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invite Codes</div>
                <div class="panel-body">


                    @if (!empty(\Session::get('invite_created')))
                        <div class="alert alert-success">
                            <p>An invite code has been created for <b>{{ \Session::get('invite_created')['name'] }}</b>!</p>
                            <p>Copy this URL and send it to them so they can join you on {{ config('app.name') }}!</p>
                            <input type="text" class="form-control invite-url-input" data-original-value="{{ \Session::get('invite_created')['url'] }}" value="{{ \Session::get('invite_created')['url'] }}">
                        </div>
                    @endif

                    <p>{{ config('app.name') }} is currently in beta, so new users will need their own unique invite link to sign up.</p>

                    @if (count($invites['unused']))
                        <p>Luckily for your friends, you can generate <em>{{ count($invites['unused']) }}</em> more {{ str_plural('code', count($invites['unused'])) }} right here!</p>
                        <form class="form-inline generate-invite" method="POST" action="{{ route('invite.create') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label sr-only">Name</label>
                                    <span class="help-block sr-only">The name of the person you're inviting</span>
                                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Invitee name" required>
                                <button type="submit" class="btn btn-primary">Generate</button>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </form>
                    @else
                        <p>Unfortunately all your invite codes have been given out 😞</p>
                    @endif

                    @if (count($invites['pending']))
                        <h4>Pending Invites</h4>
                        <div class="help-block">These invites have not been claimed yet. Click on a name to reveal its unique invite link.</div>
                        <ul class="invite-codes">
                        @foreach ($invites['pending'] as $invite)
                            <li>
                                <a class="{{ $invite->claimed_by ? 'claimed' : 'unclaimed' }}" href="{{ $invite->url }}">{{ $invite->name or 'A nameless invite' }}</a>
                            </li>
                        @endforeach
                        </ul>
                    @endif

                    @if (count($invites['claimed']))
                    <div class="invited-users">
                        <h4>Users you've invited</h4>
                        <ul>
                        @foreach ($invites['claimed'] as $invite)
                            <li><a href="{{ route('profile', $invite->claimed_by->username) }}">{!! $invite->claimed_by->avatarImg(200, 20, false) !!} {{ $invite->claimed_by->username }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
