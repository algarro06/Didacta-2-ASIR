<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = ['topic_id', 'user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(Userr::class, 'user_id');
    }
}
