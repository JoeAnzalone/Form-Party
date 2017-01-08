@foreach ($messages as $message)
<div class="panel panel-default message {{ $message->answer ? 'has-answer' : 'no-answer' }}">

    @if (!empty($show_heading))
    <div class="panel-heading">
        <a href="{{ route('profile', $message->recipient->username) }}">
            <img width="25" height="25" src="{{ $message->recipient->avatar(200) }}" alt=""></a>
        <a href="{{ route('profile', $message->recipient->username) }}">
            {{ $message->recipient->username }}</a>
        {{ $message->answer ? 'replied to' : 'received' }} this anonymous message
    </div>
    @endif
    <div class="panel-body">
        <blockquote class="message-body">{!! nl2br(e($message->body)) !!}</blockquote>

        @if ($message->answer)
            <div class="message-answer">{!! nl2br(e($message->answer)) !!}</div>
        @endif

        <div class="controls pull-right">
            @can('archive', $message)
                @include('message.archive_button')
            @endcan

            @can('unarchive', $message)
                @include('message.unarchive_button')
            @endcan

            @can('delete', $message)
                @include('message.delete_button')
            @endcan

            @can('answer', $message)
                <a class="answer-message-link btn btn-primary" href="{{ route('message.answer', $message) }}">{{ $message->answer ? 'Edit ' : '' }}Answer</a>
            @endcan
        </div>
    </div>
</div>
@endforeach

<div class="pagination-wrapper">
    {{ $messages->links() }}
</div>
