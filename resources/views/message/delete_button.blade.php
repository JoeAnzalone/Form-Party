<form class="button-form" action="{{ route('message.delete', $message) }}" method="post">
    {{ method_field('delete') }}
    {{ csrf_field() }}
    <button class="btn btn-danger" title="Delete the message" type="submit">Delete</button>
</form>
