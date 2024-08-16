<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory;

    public static $_TYPES = [
        "Manga",
        "Domo",
        "Reserva",
        "Nap 1",
        "Nap 2",
        "ONT",
    ];

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'description',
        'type',
        'reserve_meters',
        'nap_threads',
        'nap_buffers',
        'nap_ports',
        'map_id',
    ];

    protected $appends = [
        'name_auto',
    ];

    public function getNameAutoAttribute()
    {
        if ($this->name) return $this->name;
        return $this->type . " - " . $this->id;
    }

    public function map()
    {
        return $this->belongsTo(Map::class);
    }
}
