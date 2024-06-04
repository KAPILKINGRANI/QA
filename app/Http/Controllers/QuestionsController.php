<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Models\Question;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class QuestionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store']),
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
}
