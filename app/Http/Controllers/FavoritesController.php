<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FavoritesController extends Controller
{
    public function store(Request $request, Question $question)
    {
        Gate::authorize('markAsFavorite', $question);
        $question->favorites()->attach(auth()->id());
        return redirect()->back();
    }
    public function destroy(Request $request, Question $question)
    {
        Gate::authorize('markAsFavorite', $question);
        $question->favorites()->detach(auth()->id());
        return redirect()->back();
    }
}
