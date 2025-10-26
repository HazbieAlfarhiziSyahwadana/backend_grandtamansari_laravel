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
        Schema::create('article', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->unsignedBigInteger('articletype_id');
            $table->string('title', 225);
            $table->string('slug')->unique();
            $table->string('gambar', 225);
            $table->string('caption', 225)->nullable();
            $table->longText('content');
            $table->text('keyword')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('articletype_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
