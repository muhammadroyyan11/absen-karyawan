<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan',
        'level',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class, 'u_id');
    }

    public function getLeaveQuota()
    {
        $userId = Auth::user()->id;
        $employmentType = User::find($userId)->employmentType->name;

        if ($employmentType === 'Fulltime') {
            return 6;
        } elseif ($employmentType === 'Parttime') {
            return 0;
        }

        return 0;
    }
}
