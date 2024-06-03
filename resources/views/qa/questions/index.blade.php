@extends('qa.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>All Questions</h2>
                    </div>

                    @foreach ($questions as $question)
                        <div class="card-body">
                            <div class="card-title">
                                <h3>{{ $question->title }}</h3>
                                <p>{{ Str::limit($question->body, 250) }}</p>
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
