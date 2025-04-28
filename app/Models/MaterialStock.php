<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialStock extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'quantity',
        'price',
        'description',
    ];

    // menghitung total nilai stok (quantity * price)
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->price;
    }
}
