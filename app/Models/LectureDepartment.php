<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureDepartment extends Model
{
    use HasFactory;

    protected $table = 'lecture_department';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['lec_id', 'dep_no'];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lec_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_no');
    }
}
