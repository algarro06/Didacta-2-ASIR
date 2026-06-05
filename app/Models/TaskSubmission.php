<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $table = 'task_submissions';
    protected $primaryKey = 'id_submission';

    protected $fillable = [
        'item_id',
        'user_id',
        'file_path',
        'comment'
    ];

    public function item()
    {
        return $this->belongsTo(SectionItem::class, 'item_id', 'id_item');
    }

    public function user()
    {
        return $this->belongsTo(Userr::class, 'user_id', 'id_user');
    }
}