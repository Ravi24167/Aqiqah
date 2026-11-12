<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animal_hotspots', function (Blueprint $table) {
            $table->id();
            $table->enum('animal_type', ['kambing', 'sapi', 'domba']);
            $table->string('body_part'); // Kulit, Mata & Kepala, Buntut, Tanduk & Kuku, Iga, Paha, Punggung, Jeroan, Sumsum
            $table->enum('part_category', ['kuliner', 'kerajinan', 'kesehatan'])->default('kuliner');
            $table->integer('pos_x'); // percentage X 0-100
            $table->integer('pos_y'); // percentage Y 0-100
            $table->text('benefits'); // health & nutritional benefits
            $table->text('recommended_recipes'); // culinary dishes
            $table->text('utilization_details')->nullable(); // craft/leather/industrial use (bedug, rebana, jaket, sisir, dll)
            $table->string('icon')->default('fa-utensils');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_hotspots');
    }
};
