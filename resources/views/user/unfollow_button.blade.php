<form class="button-form button-form-wide" action="{{ route('user.follow', $user) }}" method="post">
    {{ method_field('delete') }}
    {{ csrf_field() }}
    <button class="btn btn-default btn-xs" type="submit">Unfollow</button>
</form>
