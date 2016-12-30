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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
