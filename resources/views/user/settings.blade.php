@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal settings-form" method="POST" action="{{ route('settings') }}">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}


                        <div class="panel panel-default profile-panel">
                        <div class="panel-heading text-center">Profile</div>
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username" class="col-md-4 control-label">Username</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}" required>

                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Display Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                    <label for="website" class="col-md-4 control-label">Website</label>

                                    <div class="col-md-6">
                                        <input id="website" type="text" class="form-control" name="website" value="{{ old('website', $user->website) }}">

                                        @if ($errors->has('website'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('website') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                    <label for="bio" class="col-md-4 control-label">Bio</label>

                                    <div class="col-md-6">
                                        <textarea id="bio" class="form-control" name="bio">{{ old('bio', $user->bio) }}</textarea>

                                        @if ($errors->has('bio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Avatar</label>
                                    <div class="col-md-6">
                                        <div class="media-left">
                                            <a target="_blank" href="{{ $user->gravatar_profile_url }}"><img class="user-avatar" src="{{ $user->avatar(200) }}" width="100" title="Your avatar" alt="Your avatar"></a>
                                        </div>
                                        <div class="media-body">
                                            <p>Change your avatar at <a rel="external" target="_blank" href="https://www.gravatar.com">Gravatar.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default account-panel">
                            <div class="panel-heading text-center">
                                <a href="{{ url('/logout') }}" class="logout-link">Logout</a>
                                Account
                            </div>
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required data-requires-password-if-changed>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">New Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" data-requires-password-if-changed>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group password-confirm-wrapper" style="display: none;">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel panel-default confirm-password-panel" style="display: none;">
                            <div class="panel-heading text-center">Account</div>
                            <div class="panel-body">
                                <p>Confirm existing password to continue</p>
                                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label for="current-password" class="col-md-4 control-label">Current Password</label>

                                    <div class="col-md-6">
                                        <input id="current-password" type="password" class="form-control" name="current-password">

                                        @if ($errors->has('current_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('current_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading text-center">Notifications</div>
                            <div class="panel-body">
                                <p class="text-center">Email me when:</p>
                                <div class="form-group{{ $errors->has('new_message_email') ? ' has-error' : '' }}">
                                    <div class="col-xs-10 col-xs-offset-2 col-sm-offset-3 col-lg-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="new_message_email" {{ $user->meta['notifications']['new_message']['email'] ? 'checked' : '' }} value="1">
                                                Someone sends me a new message
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('invitation_accepted_email') ? ' has-error' : '' }}">
                                    <div class="col-xs-10 col-xs-offset-2 col-sm-offset-3 col-lg-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="invitation_accepted_email" {{ $user->meta['notifications']['invitation_accepted']['email'] ? 'checked' : '' }} value="1">
                                                Someone uses one of my invite codes
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
