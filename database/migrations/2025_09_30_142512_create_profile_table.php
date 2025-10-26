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
        Schema::create('profile', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->string('logo', 225);
            $table->string('company', 225);
            $table->text('description');
            $table->string('address', 225);
            $table->string('telp', 225);
            $table->string('whatsapp', 225);
            $table->string('email', 225)->nullable();
            $table->string('instagram', 255);
            $table->string('facebook', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
