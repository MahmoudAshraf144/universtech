<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professors';
    protected $primaryKey = 'prof_id';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function attendances()
    {
        return $this->hasMany(ProfessorAttendance::class, 'prof_id');
    }

    public function notifications()
    {
        return $this->hasMany(ProfessorNotification::class, 'prof_id');
    }
}
