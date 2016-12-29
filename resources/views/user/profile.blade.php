@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if ($user['name'])
                        Send an anonymous message to {{ $user['name'] }} (<code>{{ $user['username'] }}</code>)
                    @else
                        Send an anonymous message to {{ $user['username'] }}
                    @endif
                </div>

                <div class="panel-body">
                    @include('user.form', ['user' => $user])
                    @include('user.published_messages', ['messages' => $messages])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
