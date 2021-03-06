@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (count($messages))
                        @foreach ($messages as $message)
                            @include('message.single')
                        @endforeach

                        <div class="pagination-wrapper">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <p>Your dashboard is empty! 🙊</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
