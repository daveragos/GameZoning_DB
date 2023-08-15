<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', // Allow mass assignment for owner_id
        'name',
        'email',
        'password',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
