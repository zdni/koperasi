<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
    ];
    protected $hidden = [
        'password',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }
    public function employees() {
        return $this->hasMany(Employee::class);
    }
    public function logs() {
        return $this->hasMany(Log::class);
    }
}
