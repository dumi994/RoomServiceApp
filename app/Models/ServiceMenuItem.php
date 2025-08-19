<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceMenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function service()
    {
        return $this->belongsToMany(Service::class, 'service_menu_item_service', 'menu_item_id', 'service_id');
    }
}
