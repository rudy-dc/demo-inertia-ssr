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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('vehicle_constructor_id')->constrained();
            $table->foreignId('vehicle_model_id')->constrained();
            $table->foreignId('vehicle_specification_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
