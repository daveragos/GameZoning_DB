<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function game() {
        return $this->belongsTo(Game::class);
    }
}
