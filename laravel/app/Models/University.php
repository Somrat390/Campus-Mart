<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this

class University extends Model
{
    // These fields match the columns we created in your migration earlier
    protected $fillable = [
        'name',
        'domain',
        'location',
    ];

    /**
     * Relationship: A University has many Students (Users)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship: A University has many Products for sale
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}