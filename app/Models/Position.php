<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($position) {
            Employee::where('position_id', $position->id)->update(['position_id' => null]);
        });
    }
}
