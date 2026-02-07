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
        Schema::create('images',function(Blueprint $table){
            $table->id();
            $table->text('food_img');
            $table->text('shop_img');
            $table->foreignId('content_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            //削除をカスケードする
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
