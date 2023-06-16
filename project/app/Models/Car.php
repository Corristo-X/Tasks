<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $guarded = [];
    // ...

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('currently_using')
                    ->withTimestamps();
    }
    public function clients()
{
    return $this->belongsToMany(Client::class, 'car_user')
        ->withTimestamps()
        ->withPivot('currently_using');
}

}
?>
