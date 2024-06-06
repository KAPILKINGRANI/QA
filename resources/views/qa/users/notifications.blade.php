@extends('qa.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>All Notifications</h1>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item">
                                    @if ($notification->type === App\Notifications\NewReplyAdded::class)
                                        A New Reply Was Added To Your Question:
                                        <a href="{{ route('questions.show', $notification->data['question']['slug']) }}">
                                            <strong>{{ $notification->data['question']['title'] }}</strong>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
