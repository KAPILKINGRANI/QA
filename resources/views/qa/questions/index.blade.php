@extends('qa.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h2>All Questions</h2>
                        {{-- If user is not logged in we are checking via @guest blade template --}}
                        @guest
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-primary">Login To Ask a Question</a>
                        @endguest
                        {{-- If user is logged in we are checking via @auth blade template --}}
                        @auth
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-primary">Ask a Question !</a>
                        @endauth
                    </div>
                    @foreach ($questions as $question)
                        <div class="row">
                            <div class="col-md-2">
                                <div class="d-flex flex-column mr-4 statistics">
                                    <div class="votes text-center mb-3">
                                        <strong class="d-block">{{ $question->votes_count }}</strong>
                                        Votes
                                    </div>
                                    <div class="text-center mb-3">
                                        <div class="answers {{ $question->answer_style }}"
                                            style="max-width: 60%; margin:0 auto">
                                            <strong class="d-block">{{ $question->answers_count }}</strong>
                                            Answers
                                        </div>
                                    </div>
                                    <div class="views text-center">
                                        <strong class="d-block">{{ $question->views_count }}</strong>
                                        Views
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <div class="card-title">
                                        <div class="d-flex justify-content-between">
                                            <h3>
                                                <a href="{{ $question->url }}">{{ $question->title }}</a>
                                            </h3>
                                            <div class="d-flex justify-content-end gap-1">
                                                @can('edit-question', $question)
                                                    <div>
                                                        <a href="{{ route('questions.edit', $question->id) }}"
                                                            class="btn btn-sm btn-outline-warning">Edit
                                                        </a>
                                                    </div>
                                                @endcan
                                                @can('delete', $question)
                                                    <form action="{{ route('questions.destroy', $question->id) }}"
                                                        class="d-inline-block" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger">DEL</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                        <p>
                                            Asked By : <a href="#">{{ $question->owner->name }}</a>
                                            <span class="text text-muted">{{ $question->created_date }}</span>
                                        </p>
                                        <p>{!! Str::limit($question->body, 250) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                    @endforeach

                    <div class="card-footer">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
