<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $table = 'student_payment';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['stud_id', 'pay_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'stud_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'pay_id');
    }
}
