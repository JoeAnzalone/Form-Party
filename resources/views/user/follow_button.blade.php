<form class="button-form" action="{{ route('user.follow', $user) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
    <button class="btn btn-primary" type="submit">Follow</button>
</form>
