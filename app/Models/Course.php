<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'id_course';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'status',
        'creation_date',
        'image',
        'view_name'
    ];

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'course_user',
            'course_id',
            'user_id'
        )->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id_course')
                    ->orderBy('order');
    }
}