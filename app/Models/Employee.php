<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function employment_contract() {
        return $this->belongsTo(EmploymentContract::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function position() {
        return $this->belongsTo(Position::class);
    }
    public function religion() {
        return $this->belongsTo(Religion::class);
    }
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function region_leadership() {
        return $this->hasMany(RegionLeadership::class);
    }
    public function account_lines() {
        return $this->hasMany(AccountLine::class);
    }
}
