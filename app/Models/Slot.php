<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'category_id',
        'warehouse_id',
        'price',
        'taken',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $lastCol = Slot::max('id');
            $wh = Auth::user()->warehouse->id;
            $model->name = 'SLT'.$wh . str_pad($lastCol+1,3,'0',STR_PAD_LEFT);
        });
    }
}
