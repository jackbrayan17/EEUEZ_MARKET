<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorefrontsTable extends Migration
{
    public function up()
    {
        Schema::create('storefronts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade'); // Foreign key to merchants
            $table->string('name');
            $table->string('category');
            $table->string('status')->default('active'); // Storefront status (active, inactive, etc.)
            $table->integer('premium_access')->default(0); // Number of premium accesses
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('storefronts');
    }
}
