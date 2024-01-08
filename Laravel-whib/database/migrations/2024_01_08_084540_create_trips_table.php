<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Foreign key to link with users table
            $table->string('trip_name');
            $table->text('trip_description')->nullable();
            $table->timestamps();
        });

        // Pivot table for the many-to-many relationship between trips and map pins
        Schema::create('map_pin_trip', function (Blueprint $table) {
            $table->foreignId('map_pin_id')->constrained('map_pins');
            $table->foreignId('trip_id')->constrained('trips');
            $table->primary(['map_pin_id', 'trip_id']);
        });
    }
};
