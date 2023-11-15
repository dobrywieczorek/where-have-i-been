<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_pins', function (Blueprint $table) {
            $table->id();
            $table->string('pin_name');
            $table->string('description')->nullable();
            $table->boolean('favourite');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->foreignId('user_id')->constrained('users');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_pins');
    }
};
