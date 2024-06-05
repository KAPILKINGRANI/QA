@extends('qa.layouts.app')

@section('page-level-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection

@section('page-level-scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endsection

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Answer</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">

                            <input id="body" type="hidden" name="body" value="{{ old('body', $answer->body) }}">
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
@endsection
