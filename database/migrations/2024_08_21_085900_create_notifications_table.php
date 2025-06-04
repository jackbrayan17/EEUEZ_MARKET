<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');  // The sender of the notification
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // The receiver of the notification
            $table->text('message'); // The message content
            $table->enum('status', ['unread', 'read'])->default('unread'); // Status of the notification
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
