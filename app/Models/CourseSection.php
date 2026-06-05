<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'course_sections';
    protected $primaryKey = 'id_section';

    protected $fillable = [
        'course_id',
        'title',
        'order'
    ];

    public function items()
    {
        return $this->hasMany(SectionItem::class, 'section_id', 'id_section')
                    ->orderBy('order');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id_course');
    }
}