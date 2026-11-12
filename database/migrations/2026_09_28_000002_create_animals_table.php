<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // DKM admin owner
            $table->string('name');
            $table->enum('type', ['kambing', 'sapi', 'domba']);
            $table->enum('category', ['aqiqah', 'qurban', 'harian'])->default('harian');
            $table->decimal('price', 12, 2);
            $table->decimal('weight_kg', 6, 2);
            $table->string('gender')->default('Jantan');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
