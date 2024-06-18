<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDepartment extends Model
{
    use HasFactory;

    protected $table = 'student_department';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['stud_id', 'dep_no'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_no');
    }
}
