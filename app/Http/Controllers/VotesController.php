<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function voteQuestion(Question $question, int $vote)
    {
        //check whether user has clicked upvote or downvote or previously
        if (auth()->user()->hasVoteForQuestion($question)) {

            //explanation is written at the end of the file
            //voted earlier now changes the vote
            if (!(($vote === 1 && auth()->user()->hasUpVoteForQuestion($question)) || ($vote === -1 && auth()->user()->hasDownVoteForQuestion($question)))) {

                $question->updateVote($vote);
            }
        }
        //voted for the first time
        else {
            $question->vote($vote);
        }

        return redirect()->back();
    }
    public function voteAnswer(Answer $answer, int $vote)
    {

        if (auth()->user()->hasVoteForAnswer($answer)) {

            if (!(($vote === 1 && auth()->user()->hasUpVoteForAnswer($answer)) || ($vote === -1 && auth()->user()->hasDownVoteForAnswer($answer)))) {
                $answer->updateVote($vote);
            }
        } else {
            $answer->vote($vote);
        }
        return redirect()->back();
    }
}

/*
if (!(($vote === 1 && auth()->user()->hasUpVoteForQuestion($question)) || ($vote === -1 && auth()->user()->hasDownVoteForQuestion($question))))

the above part handles below type of scenarios
user has upvoted already and again tries to upvote so we will need to prevent this one user can upvote only once
same for downvote also
user has downvoted already and again tries to downvote so we will need to prevent this one user can downvote only once
consider true false for each expression and u will get the desired result....

next case
if the user has upvoted before and now tries to downvote so we have to consider this.
same for downvote also
if the user has downvoted before and now tries to upvote so we have to consider this.

example
user has upvoted for the question already
now tries to downvote, so the value of each of the expression in the bracket would be
$vote == 1 ---->                                        false (since he tries to downvote now)
auth()->user()->hasUpVoteForQuestion($question))        true (already upvoted earlier)
$vote === -1--->                                        true(since he tries to downvote now)
auth()->user()->hasDownVoteForQuestion($question        false(already upvoted earlier)
and there is negation outside
!(false && true || true && false)
!(false || false)
true ----> we need to update the vote
*/
