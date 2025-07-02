<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'room_number', 'status'];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
