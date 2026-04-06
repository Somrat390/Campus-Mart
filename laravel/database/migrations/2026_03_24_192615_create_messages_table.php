<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
   {
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        // We link the message to a specific product
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
        // Who sent it and who receives it
        $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        
        $table->text('content');
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
