<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    // Allows these fields to be filled by the Seeder
    protected $fillable = ['name', 'domain'];

    // Relationship: One university has many students
    public function users()
    {
        return $this->hasMany(User::class);
    }
}