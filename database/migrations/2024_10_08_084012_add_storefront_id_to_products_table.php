<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStorefrontIdToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('storefront_id')->nullable(); // Nullable storefront_id

            // Add foreign key constraint
            $table->foreign('storefront_id')->references('id')->on('storefronts')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['storefront_id']); // Drop foreign key
            $table->dropColumn('storefront_id'); // Drop column
        });
    }
}
