<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceVehicle extends Model
{
    use HasFactory;

    protected $table = 'service_vehicles';

    protected $fillable = [
        'plate_number',
        'model',
        'owner_name',
        'notes',
    ];
}
