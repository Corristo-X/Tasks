<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'employee_id'];  // Dopasuj te do swojego schematu bazy danych

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function cars()
{
    return $this->belongsToMany(Car::class, 'car_user')
        ->withTimestamps()
        ->withPivot('currently_using');
}

}
?>
