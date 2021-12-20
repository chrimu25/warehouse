<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'warehouse_id',
        'product_id',
        'days',
        'total_price',
        'confirmed',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $lastCol = Invoice::max('id');
            $model->code = 'INV' . str_pad($lastCol+1,5,'0',STR_PAD_LEFT);
        });
    }
}
