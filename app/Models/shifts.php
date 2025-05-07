<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shifts extends Model
{
    protected $fillable = [
        'name_shift', 'time_start', 'time_end'
    ];

    // Relasi ke WorkSchedule atau Jadwal
    public function schedules()
    {
        return $this->hasMany(jadwals::class);
    }
}
