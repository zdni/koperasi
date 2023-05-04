<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function region() {
        return $this->belongsTo(Region::class);
    }
    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($unit) {
            Employee::where('unit_id', $unit->id)->update(['unit_id' => null]);
        });
    } 
}
