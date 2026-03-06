<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image_path',
        'category',
        'status',
        'user_id',
        'university_id',
    ];

    /**
     * Get the user (seller) that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the university where this product is being sold.
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}