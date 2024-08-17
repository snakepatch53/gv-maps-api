<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
    ];

    protected $appends = [
        'logo_url',
    ];

    public function getLogoUrlAttribute()
    {
        if ($this->logo == null) return asset("storage/app/public/img/business.png");
        return asset("storage/app/public/img_entities/" . $this->logo);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function maps()
    // {
    //     return $this->hasMany(Map::class);
    // }
}
