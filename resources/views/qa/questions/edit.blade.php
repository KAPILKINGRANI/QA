@extends('qa.layouts.app')

@section('page-level-styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection
@section('page-level-scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Ask a Question !</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('questions.update', $question->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter Question Title !"
                                    value="{{ old('title', $question->title) }}" class="form-control"
                                    {{ $errors->has('title') ? 'is-invalid' : '' }}>
                                @error('title')
                                    <div class="text-danger text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label for="body" class="form-label">Enter Your Question</label>
                                <input id="body" type="hidden" name="body"
                                    value="{{ old('body', $question->body) }}">
                                <trix-editor input="body"
                                    class="form-control
                                    {{ $errors->has('body') ? 'is-invalid' : '' }}"></trix-editor>
                                @error('body')
                                    <div class="text-danger text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
