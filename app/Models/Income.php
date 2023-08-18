<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_username',
        'game_name',
        'amount',
        'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_username', 'username');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_name', 'name');
    }
}
