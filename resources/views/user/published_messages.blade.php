@foreach ($messages as $message)
<div class="panel panel-default">
    <div class="panel-body">
        <blockquote>{{ $message['body'] }}</blockquote>
        {{ $message['answer'] }}
    </div>
</div>
@endforeach
