<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DayShift extends Model
{
    use HasFactory;

    // Nama tabel (jika beda dari konvensi Laravel yaitu 'day_shifts')
    protected $table = 'day_shifts';

    // Primary key (default: 'id')
    protected $primaryKey = 'id';

    // Jika primary keybukan integer increment, sesuaikan ini
    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name_day_shift',
        'shift_id',
        'time_start',
        'time_end',
    ];

    protected $casts = [
        'time_start' => 'datetime:H:i:s',
        'time_end' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function shift()
    {
        return $this->belongsTo(Shifts::class, 'shift_id');
    }
}
