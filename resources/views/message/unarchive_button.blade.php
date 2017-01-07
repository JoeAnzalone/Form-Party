<form class="button-form" action="{{ route('message.unarchive', $message) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
    <button class="btn btn-default" title="Return message to inbox" type="submit">Unarchive</button>
</form>
