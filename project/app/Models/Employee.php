<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];  // Dopasuj te do swojego schematu bazy danych

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
?>
