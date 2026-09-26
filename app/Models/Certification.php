<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'issuer',
        'cert_number',
        'valid_until',
        'description',
        'badge_image',
        'document_file',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
