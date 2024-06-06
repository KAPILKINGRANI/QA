<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answers\CreateAnswerRequest;
use App\Http\Requests\Answers\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnswersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAnswerRequest $request, Question $question)
    {
        $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        session()->flash('success', 'Your Answer Submitted Successfully!');
        return redirect($question->url);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question, Answer $answer)
    {
        Gate::authorize('update', $answer);
        return view('qa.answers._edit', compact(['question', 'answer']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Question  $question, Answer $answer)
    {

        Gate::authorize('update', $answer);
        $answer->update(['body' => $request->body]);
        session()->flash('success', 'Your Answer has been updated successfully');
        return redirect($question->url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question, Answer $answer)
    {

        Gate::authorize('delete', $answer);
        $answer->delete();
        session()->flash('success', 'Your Answer has been deleted successfully');
        return redirect($question->url);
    }
    public function markAsBest(Question $question, Answer $answer)
    {
        Gate::authorize('markAsBest', $answer);
        $answer->question->markAsBest($answer);
        return redirect()->back();
    }
}
