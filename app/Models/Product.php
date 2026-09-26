<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'raw_material',
        'product_form',
        'short_description',
        'full_description',
        'moisture_content',
        'mesh_size',
        'brix_content',
        'shelf_life',
        'storage_instruction',
        'recommendations',
        'thumbnail',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function priceTiers(): HasMany
    {
        return $this->hasMany(ProductPriceTier::class)->orderBy('min_quantity_kg', 'asc');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function getMinB2cPriceAttribute(): ?float
    {
        return $this->variants()->where('is_active', true)->whereNotNull('retail_price')->min('retail_price');
    }

    public function getMinB2bPriceAttribute(): ?float
    {
        return $this->priceTiers()->min('price_per_kg');
    }
}
