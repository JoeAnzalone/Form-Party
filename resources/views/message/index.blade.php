@foreach ($messages as $message)
<div class="panel panel-default message {{ $message['answer'] ? 'has-answer' : '' }}">
    <div class="panel-body">
        <blockquote>{!! nl2br(e($message['body'])) !!}</blockquote>
        {{ $message['answer'] }}
        @can('answer', $message)
            <a href="{{ route('message.answer', $message) }}">{{ $message['answer'] ? 'Edit ' : '' }}Answer</a>
        @endcan
    </div>
</div>
@endforeach
