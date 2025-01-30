<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users');
            $table->string('title', 200);
            $table->text('description');
            $table->string('location', 200);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->foreignId('category_id')->constrained('event_categories');
            $table->integer('max_capacity')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
