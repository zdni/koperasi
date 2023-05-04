<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionLeadership extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function accountant_employee() {
        return $this->belongsTo(Employee::class);
    }
    public function coordinator_employee() {
        return $this->belongsTo(Employee::class);
    }
    public function gm_employee() {
        return $this->belongsTo(Employee::class);
    }
    public function region() {
        return $this->belongsTo(Region::class);
    }
}
