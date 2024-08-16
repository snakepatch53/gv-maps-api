<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiberMarker extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'order',
        'fiber_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($marker) {
            $marker->handleOrder();
        });
        // order by "order" asc
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

    public function handleOrder()
    {
        if (!$this->order) {
            $this->assignOrder();
        }
        if ($this->orderExists($this->order)) {
            $this->shiftOrders();
        }
    }

    protected function assignOrder()
    {
        $lastMarker = static::where('fiber_id', $this->fiber_id)
            ->orderBy('order', 'desc')
            ->first();
        if ($lastMarker) {
            $this->order = $lastMarker->order + 1;
        } else {
            $this->order = 1;
        }
    }

    protected function orderExists($order)
    {
        return static::where('fiber_id', $this->fiber_id)
            ->where('order', $order)
            ->exists();
    }

    protected function shiftOrders()
    {
        static::where('fiber_id', $this->fiber_id)
            ->where('order', '>=', $this->order)
            ->where('id', '!=', $this->id)  // No incluir el registro actual
            ->increment('order');
    }


    // Relationships
    public function fiber()
    {
        return $this->belongsTo(Fiber::class);
    }
}
