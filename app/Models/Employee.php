<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'owner_username', // Include the new column in fillable
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_username', 'username');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
