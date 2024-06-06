<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        //observer pattern
        //when answer is created then only increase the question's answers_count
        static::created(function (Answer $answer) {
            $answer->question->increment('answers_count');
        });

        //observer pattern
        //when answer is deleted then only decrease the question's answers_count
        static::deleted(function (Answer $answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getBestAnswerStyleAttribute()
    {
        return $this->question->best_answer_id === $this->id ? 'text-success' : ' ';
    }
    public function getIsBestAttribute()
    {
        return $this->question->best_answer_id === $this->id;
    }
}
