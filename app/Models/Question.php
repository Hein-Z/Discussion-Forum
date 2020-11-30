<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'description',
        'isFixed'
    ];
    protected $appends = ['date'];
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(QuestionComment::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(QuestionLike::class, 'question_id');
    }

    public function saves()
    {
        return $this->hasMany(QuestionSave::class, 'question_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'question_tags');
    }
    public function getDateAttribute()
    {
        $c = new Carbon($this->created_at);
        return $c->diffForHumans();
    }
}
