<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'phone_number',
        'email',
        'inquiry_type',
        'product_interest',
        'estimated_volume',
        'message',
        'status',
        'admin_notes',
    ];
}
