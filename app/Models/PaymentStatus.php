<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'payment_status';
    protected $primaryKey = 'status_id';

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'pay_id');
    }
}
