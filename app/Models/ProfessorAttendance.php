<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorAttendance extends Model
{
    use HasFactory;

    protected $table = 'professor_attendance';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['prof_id', 'attend_date'];

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'prof_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attend_date');
    }
}
