<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id'];  // Dopasuj te do swojego schematu bazy danych

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);  // Zakładam, że masz tabelę `order_product` do obsługi relacji wiele do wielu
    }
}
?>
