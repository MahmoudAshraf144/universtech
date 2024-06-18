<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name','admin_id','abbrevation'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_department', 'dep_no', 'stud_id');
    }

    public function levels()
    {
        return $this->hasMany(Level::class, 'dep_no');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_department', 'dep_no', 'course_id');
    }

    public function lectures()
    {
        return $this->belongsToMany(Lecture::class, 'lecture_department', 'dep_no', 'lec_id');
    }
}
