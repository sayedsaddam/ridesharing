<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name'
    ];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
