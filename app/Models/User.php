<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules\Exists;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    //Polymorphic Relationship
    //morphedByMany

    public function votesQuestions()
    {
        return $this->morphedByMany(Question::class, 'vote')->withTimestamps();
    }

    public function votesAnswers()
    {
        return $this->morphedByMany(Answer::class, 'vote')->withTimestamps();
    }

    public function getAvatarAttribute()
    {
        $size = 40;
        return "https://ui-avatars.com/api/?name={$this->name}&rounded=true&size={$size}";
    }
    public function hasUpVoteForQuestion(Question $question)
    {
        //upvote ka type 1 humne rakha hai its better to make interface for constants
        return $this->votesQuestions()->where(['vote' => 1, 'vote_id' => $question->id])->exists();
    }
    public function hasDownVoteForQuestion(Question $question)
    {
        //downvote ka type -1 humne rakha hai its better to make interface for constants
        return $this->votesQuestions()->where(['vote' => -1, 'vote_id' => $question->id])->exists();
    }
    public function hasVoteForQuestion(Question $question)
    {
        return  $this->hasUpVoteForQuestion($question) ||  $this->hasDownVoteForQuestion($question);
    }

    public function hasUpVoteForAnswer(Answer $answer)
    {
        return $this->votesAnswers()->where(['vote' => 1, 'vote_id' => $answer->id])->exists();
    }
    public function hasDownVoteForAnswer(Answer $answer)
    {

        return $this->votesAnswers()->where(['vote' => -1, 'vote_id' => $answer->id])->exists();
    }
    public function hasVoteForAnswer(Answer $answer)
    {
        return $this->hasUpVoteForAnswer($answer) || $this->hasDownVoteForAnswer($answer);
    }
}
