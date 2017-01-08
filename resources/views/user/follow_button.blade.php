<form class="button-form button-form-wide" action="{{ route('user.follow', $user) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
    <button class="btn btn-primary" type="submit">Follow</button>
</form>
