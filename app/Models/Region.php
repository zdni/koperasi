<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];  

    public function region_leaderships() {
        return $this->hasMany(RegionLeadership::class);
    }
    public function units() {
        return $this->hasMany(Unit::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($region) {
            Unit::where('region_id', $region->id)->update(['region_id' => null]);
            $region->region_leaderships()->delete();
        });
    } 
}
