<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 8, 2); // Handles up to 999,999.99
            $table->string('image_path'); // Path to the product photo
            $table->string('category'); // e.g., Electronics, Books, Furniture
            $table->enum('status', ['available', 'pending', 'sold'])->default('available');
            
            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Seller
            $table->foreignId('university_id')->constrained()->onDelete('cascade'); // The Campus
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
