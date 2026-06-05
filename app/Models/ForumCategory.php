<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = ['name', 'description'];

    public function topics()
    {
        return $this->hasMany(ForumTopic::class, 'category_id');
    }
}
