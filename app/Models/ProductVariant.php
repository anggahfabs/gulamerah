<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'packaging_name',
        'packaging_type',
        'unit_weight_kg',
        'retail_price',
        'is_active',
    ];

    protected $casts = [
        'unit_weight_kg' => 'float',
        'retail_price' => 'float',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
