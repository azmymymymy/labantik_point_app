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
        Schema::create('p_violations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p_category_id');
            $table->string('name');
            $table->unsignedInteger('point');
            $table->timestamps();

            $table->foreign('p_category_id')->references('id')->on('p_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_violations');
    }
};
