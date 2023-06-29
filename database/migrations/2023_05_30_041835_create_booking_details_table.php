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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('users_id');
            $table->bigInteger('vehicle_id');
            $table->bigInteger('drivers_id');

            $table->longText('information')->nullable();
            $table->string('tanggal');
            $table->string('waktu');
            $table->longText('reason_cancel')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('first_km')->nullable();
            $table->string('final_km')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
