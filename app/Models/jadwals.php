<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class jadwals extends Model
{
    use HasFactory;

    protected $table = 'work_schedules';

    protected $fillable = [
        'user_id',
        'shift_id',
        'date',
    ];

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shifts::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value);
    }
}
