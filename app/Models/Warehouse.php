<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','code','email','phone','type',
        'province_id', 'district_id', 'sector_id', 'cell_id',
        'category_id','owner','user_id','fork_lifter',
        'num_of_slots','active','picture']; 

    /**
     * Get the manager that owns the Warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    public function cell()
    {
        return $this->belongsTo(Cell::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function clients()
    {
        return $this->hasManyThrough(User::class, Product::class,'owner_id');
    }
    
    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $lastCol = Warehouse::max('id');
            $model->code = 'WH-' . str_pad($lastCol+1,5,'0',STR_PAD_LEFT);
        });
    }
}