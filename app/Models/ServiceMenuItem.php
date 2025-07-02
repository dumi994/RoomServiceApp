<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceMenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'name', 'description', 'price'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
