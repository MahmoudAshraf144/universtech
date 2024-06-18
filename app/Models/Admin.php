<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function professors()
    {
        return $this->hasMany(Professor::class, 'admin_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'admin_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'admin_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'admin_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'admin_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'admin_id');
    }
}
