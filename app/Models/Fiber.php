<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiber extends Model
{
    use HasFactory;

    public static $_TYPES = [
        "ADSS",
        "Mini ADSS",
        "Drop"
    ];

    protected $fillable = [
        'name',
        'type',
        'threads',
        'serie',
        'description',
        'map_id'
    ];

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function fiberMarkers()
    {
        return $this->hasMany(FiberMarker::class);
    }
}
