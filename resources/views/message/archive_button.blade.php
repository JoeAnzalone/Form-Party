<form action="{{ route('message.archive', $message) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
    <button class="btn btn-default" type="submit">Archive</button>
</form>
