@if (Auth::user())
    @if (
        (Auth::user()->can('answer', $message) && $message->is_public) ||
        Auth::user()->can('archive', $message) ||
        Auth::user()->can('unarchive', $message) ||
        Auth::user()->can('delete', $message)
    )
        <div class="dropdown pull-right">
            <button class="btn btn-default btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                @if (Auth::user()->can('answer', $message) && $message->is_public)
                    <li><a href="{{ route('message.answer', $message) }}">Edit Answer</a></li>
                @endcan

                @can('archive', $message)
                    <li>@include('message.archive_button')</li>
                @endcan

                @can('unarchive', $message)
                    <li>@include('message.unarchive_button')</li>
                @endcan

                @can('delete', $message)
                    <li>@include('message.delete_button')</li>
                @endcan
            </ul>
        </div>
    @endif
@endif
