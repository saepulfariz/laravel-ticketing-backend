<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'location',
        'phone',
        'city',
        'verify_status',
    ];
}
