<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug'];

    /**
     * Get all of the products for the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockin()
    {
        return $this->hasMany(Product::class);
    }
}
