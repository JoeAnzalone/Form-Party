<form class="button-form" action="{{ route('user.follow', $user) }}" method="post">
    {{ method_field('delete') }}
    {{ csrf_field() }}
    <button class="btn btn-danger" type="submit">Unfollow</button>
</form>
