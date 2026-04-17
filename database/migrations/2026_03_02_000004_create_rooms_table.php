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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->integer('seat');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->integer('projector')->default(0);
            $table->integer('whiteboard')->default(0);
            $table->integer('tv')->default(0);
            $table->integer('video_conference')->default(0);
            $table->integer('hide')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
