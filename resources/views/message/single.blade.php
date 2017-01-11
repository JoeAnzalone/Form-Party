<div class="panel panel-default message {{ $message->answer ? 'has-answer' : 'no-answer' }}">
    @if (!empty($show_heading))
    <div class="panel-heading">
        <a href="{{ route('profile', $message->recipient->username) }}">
            <img width="25" height="25" src="{{ $message->recipient->avatar(200) }}" alt=""></a>
        <a href="{{ route('profile', $message->recipient->username) }}">
            {{ $message->recipient->username }}
        </a>
        {{ $message->answer ? 'replied to' : 'received' }} this anonymous message
        @include('message.context-menu')
    </div>
    @endif
    <div class="panel-body">
        <blockquote class="message-body">{!! nl2br(e($message->body)) !!}</blockquote>

        @if ($message->answer)
            <div class="message-answer">{!! nl2br(e($message->answer)) !!}</div>
        @endif

        <div class="pull-right">
            @if (Auth::user() && Auth::user()->can('answer', $message) && !$message->answered_at)
                <a class="answer-message-link btn btn-primary" href="{{ route('message.answer', $message) }}">Answer</a>
            @endcan
        </div>

        @if (empty($show_heading))
            <div class="headerless-context-menu">
                @include('message.context-menu')
            </div>
        @endif
    </div>
</div>
