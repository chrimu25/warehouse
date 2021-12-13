<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'from',
        'to',
        'slot_id',
        'product_id',
        'category_id',
        'unity_id',
        'owner',
        'until',
        'quantity',
        'incharge',
        'status',
        'approved',
    ];

    protected $dates = ['until'];

    public function owner1()
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from', 'id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to', 'id');
    }

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id', 'id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function incharge()
    {
        return $this->belongsTo(User::class, 'incharge', 'id');
    }
}
