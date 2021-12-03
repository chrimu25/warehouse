<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'remaining',
        'category_id',
        'unity_id',
        'warehouse_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $lastCol = Slot::max('id');
            $model->name = 'Slot' . str_pad($lastCol+1,6,'0',STR_PAD_LEFT);
        });
    }
}
