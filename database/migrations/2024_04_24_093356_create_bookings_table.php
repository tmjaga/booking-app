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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('customer_id')->constrained('customers');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->double('total_price', 8, 2)->default(0.00);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->unique(['id', 'room_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
