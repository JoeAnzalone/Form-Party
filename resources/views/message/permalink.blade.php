@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-body">
                    @include('message.single')
                </div><!-- .panel-body -->
            </div><!-- .panel.panel-default -->
        </div><!-- .col-md-8.col-md-offset-2 -->
    </div><!-- .row -->
</div>
@endsection
