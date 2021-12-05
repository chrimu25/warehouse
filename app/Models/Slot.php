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
        'remaining',
        'item_id',
        'unity_id',
        'warehouse_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class,'item_id','id');
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class,'unity_id','id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
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
