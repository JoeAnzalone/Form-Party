@foreach ($messages as $message)
<div class="panel panel-default message {{ $message->answer ? 'has-answer' : 'no-answer' }}">
    <div class="panel-body">
        <blockquote class="message-body">{!! nl2br(e($message->body)) !!}</blockquote>

        @if ($message->answer)
            <div class="message-answer">{!! nl2br(e($message->answer)) !!}</div>
        @endif

        @can('answer', $message)
            <a class="answer-message-link" href="{{ route('message.answer', $message) }}">{{ $message->answer ? 'Edit ' : '' }}Answer</a>
        @endcan
    </div>
</div>
@endforeach

<div class="pagination-wrapper">
    {{ $messages->links() }}
</div>
