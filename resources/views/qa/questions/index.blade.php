@extends('qa.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>All Questions</h2>
                    </div>
                    <div class="row">
                        @foreach ($questions as $question)
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
                                        <h3>
                                            <a href="{{ $question->url }}">{{ $question->title }}</a>
                                        </h3>
                                        <p>
                                            Asked By : <a href="#">{{ $question->owner->name }}</a>
                                            <span class="text text-muted">{{ $question->created_date }}</span>
                                        </p>
                                        <p>{{ Str::limit($question->body, 250) }}</p>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
