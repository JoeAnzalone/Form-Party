@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->username_possessive }} favorite people</div>
                <div class="panel-body">
                    @include('user.index', ['show_usernames' => true])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
