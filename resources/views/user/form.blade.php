<form class="form-horizontal" method="POST" action="{{ url('/messages') }}">
    {{ csrf_field() }}

    <input name="recipient_id" type="hidden" value="{{ $user['id'] }}">

    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
        <label for="message" class="col-md-12 control-label">Message for {{ $user['username'] }}</label>

        <div class="col-md-12">
            <textarea rows="10" id="message" class="form-control" name="message" required>{{ old('message') }}</textarea>

            @if ($errors->has('message'))
            <span class="help-block">
                <strong>{{ $errors->first('message') }}</strong>
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
