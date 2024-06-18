<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students'; // Ensure the table name matches your table creation
    protected $primaryKey = 'stud_id';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'student_department', 'stud_id', 'dep_no');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course', 'stud_id', 'course_id');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'student_payment', 'stud_id', 'pay_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'stud_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'stud_id');
    }
}
