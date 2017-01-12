<?php
    $summarized = isset($summarized) ? $summarized : true;
?>
<div class="panel panel-default message {{ $message->answer ? 'has-answer' : 'no-answer' }}">
    <div class="panel-heading">
        @if ($message->answered_at)
            <a class="avatar" href="{{ route('profile', $message->recipient->username) }}">
                <img width="25" height="25" src="{{ $message->recipient->avatar(200) }}" alt="">
            </a>

            <a href="{{ route('profile', $message->recipient->username) }}">{{ $message->recipient->username }}</a>

            {{ $message->answer ? 'replied to' : 'shared' }} this anonymous message

            <a class="permalink" title="{{ $message->answered_at->format('D, F jS Y @ g:i:s a') }}" href="{{ route('message.permalink', [$message->recipient, $message]) }}">
                {{ $message->answered_at->diffForHumans() }}
            </a>
        @else
            Someone sent you this
            <span title="{{ $message->created_at->format('D, F jS Y @ g:i:s a') }}">
                {{ $message->created_at->diffForHumans() }}
            </span>
        @endif

        @include('message.context-menu')
    </div>
    <div class="panel-body">
        <blockquote class="message-body">
            @if ($summarized)
                {!! nl2br(e($message->body_summary)) !!}
                @if (strlen($message->body) > App\Message::SUMMARY_LENGTH)
                    <a href="{{ route('message.permalink', [$message->recipient->username, $message]) }}">Keep reading ⧁</a>
                @endif
            @else
                {!! nl2br(e($message->body)) !!}
            @endif
        </blockquote>

        @if ($message->answer)
            <div class="message-answer">
                @if ($summarized)
                    {!! nl2br(e($message->answer_summary)) !!}
                    @if (strlen($message->answer) > App\Message::SUMMARY_LENGTH)
                        <a href="{{ route('message.permalink', [$message->recipient->username, $message]) }}">Keep reading ⧁</a>
                    @endif
                @else
                    {!! nl2br(e($message->answer)) !!}
                @endif
            </div>
        @endif

        <div class="pull-right">
            @if (Auth::user() && Auth::user()->can('answer', $message) && !$message->answered_at)
                <a class="answer-message-link btn btn-primary" href="{{ route('message.answer', $message) }}">Answer</a>
            @endcan
        </div>
    </div>
</div>
