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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_town');
            $table->string('sender_quarter');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_town');
            $table->string('receiver_quarter');
            $table->string('product_info');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->string('payment');
            $table->string('status')->default('Pending');
            $table->foreignId('sender_address_id')->nullable()->constrained('addresses')->onDelete('cascade');
            $table->foreignId('receiver_address_id')->nullable()->constrained('addresses')->onDelete('cascade');
    
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
