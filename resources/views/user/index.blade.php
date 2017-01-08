<ul class="users {{ $show_usernames ? 'show-usernames' : 'hide-usernames' }}">
    @foreach ($users as $user)
        <li title="{{ $user->username }}">
            {!! $user->avatarImg(200) !!}
            @if ($show_usernames)
                <a href="{{ $user->url }}">{{ $user->username }}</a>
            @endif
        </li>
    @endforeach
</ul>
