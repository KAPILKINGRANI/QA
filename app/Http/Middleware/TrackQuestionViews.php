<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackQuestionViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //it would be look like in hashmap
        //viewed_question_1 = true
        $question = $request->route()->slug;
        if (!session()->has('viewed_question_' . $question->id)) {
            $question->increment('views_count');
            session(['viewed_question_' . $question->id => true]);
        }
        return $next($request);
    }
}
