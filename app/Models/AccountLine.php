<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountLine extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function account() {
        return $this->belongsTo(Account::class);
    }
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
