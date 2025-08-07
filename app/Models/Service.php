<?php

namespace App\Models;

use App\Models\ServiceMenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'icon', 'description',  'images', 'available'];
    protected $casts = [
        'images' => 'array',
    ];
    public function menu_items()
    {
        return $this->hasMany(ServiceMenuItem::class, 'service_id');
    }
}
