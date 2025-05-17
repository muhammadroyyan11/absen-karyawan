<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    protected $fillable = [
        'name_shift', 'time_start', 'time_end'
    ];

    // Relasi ke WorkSchedule atau Jadwal
    public function schedules()
    {
        return $this->hasMany(jadwals::class);
    }

    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class, 'shift_id');
    }
}
