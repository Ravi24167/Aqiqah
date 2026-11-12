<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('guest_token'); // guest session identifier
            $table->string('guest_name')->default('Tamu');
            $table->foreignId('dkm_id')->constrained('users')->onDelete('cascade');
            $table->enum('sender_type', ['guest', 'dkm']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
