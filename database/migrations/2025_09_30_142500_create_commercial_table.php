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
        Schema::create('commercial', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->string('name', 225);
            $table->string('slug', 225)->nullable()->unique();
            $table->string('img_commercial', 225);
            $table->string('img_area', 225);
            $table->unsignedInteger('land_area');
            $table->unsignedInteger('floor_area');
            $table->string('hargamulai', 225);
            $table->string('width', 225);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial');
    }
};
