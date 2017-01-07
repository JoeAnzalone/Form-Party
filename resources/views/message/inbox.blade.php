@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-pills inbox-nav">
                                <li role="presentation" {!! Route::is('inbox') ? 'class="active"' : '' !!}><a href="{{ route('inbox') }}">Unanswered</a></li>
                                <li role="presentation" {!! Route::is('message.viewArchive') ? 'class="active"' : '' !!}><a href="{{ route('message.viewArchive') }}">Archive</a></li>
                            </ul>
                        </div>
                    </div>

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
