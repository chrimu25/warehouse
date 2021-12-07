<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'warehouse_id',
        'quantity',
        'old_quantity',
        'type',
        'status',
    ];
}
