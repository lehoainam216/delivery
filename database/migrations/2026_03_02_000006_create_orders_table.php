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
            $table->date('date_meeting');

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->time('time_start');
            $table->time('time_end');
            $table->string('subject');
            $table->string('registered_by');

            $table->foreignId('drink_id')
                ->constrained('drinks')
                ->cascadeOnDelete();

            $table->integer('amount');
            $table->integer('phone_number');

            $table->foreignId('status_id')
                ->constrained('statuses')
                ->cascadeOnDelete();

            // ❗ FK này KHÔNG cascade
            $table->foreignId('request_id')
                ->constrained('requests')
                ->onDelete('no action');

            $table->text('note')->nullable();
            $table->string('uuid');
            $table->integer('hide')->default(0);
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
