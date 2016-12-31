@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    @include('auth.login_form')
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Form Whaa??</div>
                <div class="panel-body">
                    <h3>Form <em>Party!</em></h3>

                    <p>You're looking at the internet's hottest new anonymous question and answer site. Folks from all over the tri-state area gather here👇 to share secrets, confess their love, or just talk smack to their e-pals. 💌</p>

                    <p>It's like a party, with forms!</p>

                    <p>Form Party is currently invite-only and in beta, but anyone can send messages to current members (that's the whole point!)</p>

                    <p>If you're interested in setting up a form for yourself, you can try asking <a href="{{ route('profile', 'joe') }}">Joe</a>. (nicely)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
