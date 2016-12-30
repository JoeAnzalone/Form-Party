@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-body">

                    <blockquote>{{ $message['body'] }}</blockquote>

                    <form class="form-horizontal" method="POST" action="{{ route('message.answer', $message) }}">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                            <label for="answer" class="col-md-12 control-label">Answer</label>

                            <div class="col-md-12">
                                <textarea rows="10" id="answer" class="form-control" name="answer">{{ old('answer') }}</textarea>

                                @if ($errors->has('answer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('answer') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right">Send</button>
                            </div>
                        </div>

                    </form>
                </div><!-- .panel-body -->
            </div><!-- .panel.panel-default -->
        </div><!-- .col-md-8.col-md-offset-2 -->
    </div><!-- .row -->
</div>
@endsection
