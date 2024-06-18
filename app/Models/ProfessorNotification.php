<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorNotification extends Model
{
    use HasFactory;

    protected $table = 'professor_notification';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['prof_id', 'notifi_id'];

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'prof_id');
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notifi_id');
    }
}
