<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycsTable extends Migration
{
    public function up()
    {
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('family_member_name');
            $table->string('family_member_phone');
            $table->string('relation');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kycs');
    }
}
