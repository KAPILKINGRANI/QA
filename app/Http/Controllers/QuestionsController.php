<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Models\Question;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store', 'edit', 'update']),
            new Middleware('trackQuestionsView', only: ['show']),


        ];
    }
    public function index()
    {
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('qa.questions.index', compact('questions'));
    }
    public function create()
    {
        return view('qa.questions.create');
    }
    public function store(CreateQuestionRequest $request)
    {
        auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        session()->flash('success', 'Question has been added successfully !');
        return redirect(route('questions.index'));
    }
    public function edit(Question $question)
    {
        //One Method

        // if (!Gate::allows('update', $question)) {
        //     abort(403);
        // }

        //2nd Method
        Gate::authorize('update', $question);
        return view('qa.questions.edit', compact(['question']));
    }
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);
        $question->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        session()->flash('success', 'Question has been Updated successfully !');
        return redirect(route('questions.index'));
    }
    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);
        $question->delete();
        session()->flash('success', 'Question has been Deleted successfully !');
        return redirect(route('questions.index'));
    }
    public function show(Question $question)
    {
        return view('qa.questions.show', compact(['question']));
    }
}
