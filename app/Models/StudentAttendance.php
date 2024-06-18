<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $table = 'student_attendance';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['attend_date', 'stud_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attend_date');
    }
}
