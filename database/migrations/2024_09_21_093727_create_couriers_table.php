<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->unique();
            $table->string('name');
            // $table->string('phone')->unique();
            $table->string('vehicle_brand');
            $table->string('vehicle_registration_number')->unique();
            $table->string('vehicle_color');
            $table->string('availability');
            $table->string('city');
            $table->string('neighborhood');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('couriers');
    }
}
