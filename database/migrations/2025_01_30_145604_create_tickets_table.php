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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('guest_id')->constrained('guests');
            $table->string('ticket_code', 100)->unique();
            $table->timestamp('issued_at');
            $table->foreignId('category_id')->constrained('ticket_categories');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'cancelled'])->default('unpaid');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
