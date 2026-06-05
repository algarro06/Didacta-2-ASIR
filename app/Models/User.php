<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'userr';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'surname',
        'mail',
        'password',
        'registration_date',
        'status',
        'id_role',
        'full_name'
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
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