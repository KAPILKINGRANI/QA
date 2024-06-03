<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->paginate(10);
        return view('qa.questions.index', compact('questions'));
    }
}
