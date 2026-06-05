<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionItem extends Model
{
    protected $table = 'section_items';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'section_id',
        'type',
        'title',
        'file_path',
        'description',
        'due_date',
        'order'
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'id_section');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class, 'item_id', 'id_item');
    }
}