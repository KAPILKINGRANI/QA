<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];

    //This is for if u change the title then slug should also get updated automatically
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }
    public function getUrlAttribute()
    {
        return "questions/{$this->slug}";
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getAnswerStyleAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "has-best-answer";
            }
            return "answered";
        }
        return "unanswered";
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function markAsBest(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}
