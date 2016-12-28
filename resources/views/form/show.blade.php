@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Form for {{ $user['name'] }}</div>

                <div class="panel-body">
                    <p>Username: <code>{{ $user['username'] }}</code></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
