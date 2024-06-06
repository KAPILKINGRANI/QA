@extends('qa.layouts.app')
@section('page-level-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $question->title }}</h1>
                    </div>
                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between mr-3">
                            <div>
                                <div class="d-flex">
                                    <div>
                                        @auth
                                            <form action="{{ route('questions.vote', [$question, 1]) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Up Vote"
                                                    class="vote-up d-block text-center {{ auth()->user()->hasUpVoteForQuestion($question) ? 'text-success' : 'text-dark' }}">
                                                    <i class="fa fa-caret-up fa-3x"></i>
                                                </button>
                                            </form>
                                            <h4 class="votes-count  text-center m-0">
                                                {{ $question->votes_count }}
                                            </h4>

                                            <form action="{{ route('questions.vote', [$question, -1]) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Down Vote"
                                                    class="vote-down d-block text-center {{ auth()->user()->hasDownVoteForQuestion($question) ? 'text-danger' : 'text-dark' }}">
                                                    <i class="fa fa-caret-down fa-3x"></i>
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                    <div
                                        class="ml-4 mt-2 text-center {{ $question->is_favorite ? 'text-warning' : 'text-black' }}">
                                        <form
                                            action="{{ route($question->is_favorite ? 'questions.unfavorite' : 'questions.favorite', $question) }}"
                                            method="POST">
                                            @csrf
                                            @if ($question->is_favorite)
                                                @method('DELETE')
                                            @endif
                                            <button type="submit"
                                                title="{{ $question->is_favorite ? 'Mark As UnFav' : 'Mark As Fav' }}">
                                                <i class="fa fa-star fa-2x"></i>
                                            </button>
                                            <h4>{{ $question->favorites_count }}</h4>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="text-muted mb-2 text-right">
                                    Asked At : {{ $question->created_date }}
                                </div>
                                <div class="d-flex mb-2">
                                    <div>
                                        <img src="{{ $question->owner->avatar }}"
                                            alt="Avatar of {{ $question->owner->name }}">
                                    </div>
                                    <div class="mt-2 ml-2">
                                        {{ $question->owner->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @include('qa.answers._create')
        @endauth
        @include('qa.answers._index')
    </div>
@endsection
@section('page-level-scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endsection
