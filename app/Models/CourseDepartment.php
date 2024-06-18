<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDepartment extends Model
{
    use HasFactory;

    protected $table = 'course_department';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['course_id', 'dep_no'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_no');
    }
}
