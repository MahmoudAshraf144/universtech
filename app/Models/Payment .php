<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'pay_id';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_payment', 'pay_id', 'stud_id');
    }

    public function methods()
    {
        return $this->hasMany(PaymentMethod::class, 'pay_id');
    }

    public function statuses()
    {
        return $this->hasMany(PaymentStatus::class, 'pay_id');
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class, 'pay_id');
    }
}
