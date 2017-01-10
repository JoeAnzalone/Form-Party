<form class="button-form" action="{{ route('message.archive', $message) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
    <button class="btn btn-link btn-block" type="submit">Archive</button>
</form>
