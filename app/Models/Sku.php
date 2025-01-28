<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'category',
        'price',
        'stock',
        'day_type',
    ];


    public function vendor()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
