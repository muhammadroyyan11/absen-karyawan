<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'u_id',
        'shift_id',
        'tgl_presensi',
        'jam_in',
        'jam_out',
        'foto_in',
        'foto_out',
        'location_in',
        'location_out',
    ];

    protected $casts = [
        'tgl_presensi' => 'date',
        'jam_in' => 'datetime:H:i:s',
        'jam_out' => 'datetime:H:i:s',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'u_id');
    }

    // (Optional) Jika nanti relasi ke shift ditambahkan
    public function shifts()
    {
        return $this->belongsTo(Shifts::class, 'shift_id');
    }
}
