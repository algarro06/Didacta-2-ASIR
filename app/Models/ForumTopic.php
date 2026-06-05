<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $fillable = ['category_id', 'user_id', 'title'];

    public function user()
    {
        return $this->belongsTo(Userr::class, 'user_id'); // tu tabla userr
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'topic_id');
    }
}
