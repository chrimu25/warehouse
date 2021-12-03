<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['item_id','quantity','status','owner_id','category_id','unity_id','warehouse_id','incharge','duration'];

    /**
     * Get the item that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function slots()
    {
        return $this->belongsToMany(Slot::class, 'slot_id', 'id');
    }

    public function incharge()
    {
        return $this->belongsTo(User::class, 'incharge', 'id');
    }
}
