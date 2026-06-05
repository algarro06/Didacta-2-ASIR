<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Course;

class Userr extends Authenticatable
{
    protected $table = 'userr';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'surname',
        'mail',
        'password',
        'id_role',
        'status',
        'registration_date',
        'full_name'
    ];

    protected $hidden = [
        'password'
    ];

    public $timestamps = false;

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'course_user',
            'user_id',
            'course_id'
        )->withTimestamps();
    }
}