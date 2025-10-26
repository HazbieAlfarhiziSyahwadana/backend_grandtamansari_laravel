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
        Schema::create('slideshow', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->string('title', 225)->nullable();
            $table->string('gambar_desktop', 225)->nullable();
            $table->string('gambar_mobile', 225)->nullable();
            $table->string('link', 225)->nullable();
            $table->unsignedInteger('sort')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slideshow');
    }
};
