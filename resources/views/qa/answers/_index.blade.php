<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>{{ Str::plural('Answer', $question->answers_count) }}</h3>
            </div>
            <div class="card-body">
                @foreach ($question->answers as $answer)
                    {!! $answer->body !!}
                    <div class="d-flex justify-content-between mr-3">
                        <div>
                            @can('update', $answer)
                                <a href="{{ route('questions.answers.edit', [$question, $answer]) }}"
                                    class="btn btn-outline-warning btn-sm">Edit</a>
                            @endcan
                            @can('delete', $answer)
                                <form action="{{ route('questions.answers.destroy', [$question, $answer]) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="sumbit" class="btn btn-outline-danger btn-sm">Del</button>
                                </form>
                            @endcan
                            <div class="d-flex">
                                <div>
                                    @auth
                                        {{-- for type of vote we have define a constant i.e 1 indicates upvote --}}
                                        {{-- similarly for down vote we have define a constant i.e -1  --}}
                                        <form action="{{ route('answers.vote', [$answer, 1]) }}" method="POST">
                                            @csrf
                                            <button type="submit" title="Up Vote"
                                                class="vote-up d-block text-center
                                                {{ auth()->user()->hasUpVoteForAnswer($answer) ? 'text-success' : 'text-dark' }}">
                                                <i class="fa fa-caret-up fa-3x"></i>
                                            </button>
                                        </form>
                                        <h4 class="votes-count text-center m-0">
                                            {{ $answer->votes_count }}
                                        </h4>

                                        <form action="{{ route('answers.vote', [$answer, -1]) }}" method="POST">
                                            @csrf
                                            <button type="submit" title="Down Vote"
                                                class="vote-down d-block text-center {{ auth()->user()->hasDownVoteForAnswer($answer) ? 'text-danger' : 'text-dark' }}">
                                                <i class="fa fa-caret-down fa-3x"></i>
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                                <div class="ml-4 mt-2">
                                    @can('markAsBest', $answer)
                                        <form action="{{ route('questions.answers.markAsBest', [$question, $answer]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn">
                                                <i class="fa fa-check fa-2x {{ $answer->best_answer_style }}"></i>
                                            </button>
                                        </form>
                                    @else
                                        @if ($answer->is_best)
                                            <i class="fa fa-check fa-2x {{ $answer->best_answer_style }}"></i>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="text-muted mb-2 text-right">
                                Answered At : {{ $answer->created_date }}
                            </div>
                            <div class="d-flex mb-2">
                                <div>
                                    <img src="{{ $answer->author->avatar }}"
                                        alt="Avatar of {{ $answer->author->name }}">
                                </div>
                                <div class="mt-2 ml-2">
                                    {{ $answer->author->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
