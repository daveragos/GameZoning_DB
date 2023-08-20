<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


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
