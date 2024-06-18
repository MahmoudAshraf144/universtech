<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'course_name',
        'no_of_hours',
        'course_code',
        'cover_image',
        'department_id',
        'professor_id',
        'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');

    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'course_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function students()
    {
        // Assuming a many-to-many relationship between courses and students
        return $this->belongsToMany(User::class, 'student_courses', 'course_id', 'student_id');
    }

}
