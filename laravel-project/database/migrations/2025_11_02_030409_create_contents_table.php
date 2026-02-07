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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('food_name');
            $table->string('shop_name');
            $table->string('price');
            $table->string('visit_date');
            $table->text('place');
            $table->text('thoughts')->nullable();
            $table->timestamps();
            $table->foreignId('user_id');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('contents');
    }
};
