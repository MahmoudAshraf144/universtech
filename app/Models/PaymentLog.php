<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';
    protected $primaryKey = 'log_id';

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'pay_id');
    }
}
