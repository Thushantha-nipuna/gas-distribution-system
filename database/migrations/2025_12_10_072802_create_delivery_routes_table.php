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
        Schema::create('delivery_routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('driver_name');
            $table->string('assistant_name')->nullable();
            $table->date('route_date');
            $table->time('planned_start_time')->nullable();
            $table->time('actual_start_time')->nullable();
            $table->time('planned_end_time')->nullable();
            $table->time('actual_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_routes');
    }
};
