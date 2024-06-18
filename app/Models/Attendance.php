<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $primaryKey = 'attend_date';
    public $incrementing = false;
    protected $fillable = ['date', 'status','reason','student_id','professor_id','lec_id','course_id'];

    protected $dates = ['attend_date'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_attendance', 'attend_date', 'stud_id');
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_attendance', 'attend_date', 'prof_id');
    }
}
