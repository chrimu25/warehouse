<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    /**
     * Get all of the items for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function warehouse()
    {
        return $this->belongsToMany(Warehouse::class, 'category_warehouse', 'category_id', 'warehouse_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
