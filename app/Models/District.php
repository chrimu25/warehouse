<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = ['province_id','name'];

    /**
     * Get all of the warehouse for the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouse()
    {
        return $this->hasMany(Warehouse::class);
    }
}
