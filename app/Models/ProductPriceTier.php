<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPriceTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'min_quantity_kg',
        'max_quantity_kg',
        'price_per_kg',
        'note',
    ];

    protected $casts = [
        'min_quantity_kg' => 'float',
        'max_quantity_kg' => 'float',
        'price_per_kg' => 'float',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
