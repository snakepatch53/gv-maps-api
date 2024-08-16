<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'entity_id',
        'user_id',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fibers()
    {
        return $this->hasMany(Fiber::class);
    }

    public function markers()
    {
        return $this->hasMany(Marker::class);
    }
}
