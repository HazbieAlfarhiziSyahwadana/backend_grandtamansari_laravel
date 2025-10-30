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
        Schema::create('unit_type', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->id();
            $table->string('name', 225);
            $table->string('slug')->unique();
            $table->string('img_facade', 225);
            $table->string('img_facade_mobile', 225);
            $table->string('img_layout', 225);
            $table->unsignedInteger('land_area');
            $table->unsignedInteger('floor_area');
            $table->unsignedTinyInteger('bedroom');
            $table->unsignedTinyInteger('bathroom');
            $table->unsignedTinyInteger('floor');
            $table->unsignedInteger('electricity');
            $table->unsignedTinyInteger('carport');
            $table->string('width', 225);
            $table->string('price', 150)->nullable();
            $table->string('promo_price', 150)->nullable();
            $table->unsignedInteger('sisa_unit')->nullable();
            $table->text('specification')->nullable();
            $table->string('keyword')->nullable();
            $table->boolean('active')->default(true);
            
            // Kolom baru untuk galeri show unit
            $table->string('img_gallery', 225)->nullable(); // Path gambar gallery utama
            $table->string('img_gallery_mobile', 225)->nullable(); // Path gambar gallery utama versi mobile
            $table->string('caption', 225)->nullable(); // Caption untuk gallery
            $table->string('alt_text', 225)->nullable(); // Alt text untuk SEO
            $table->unsignedInteger('sort')->default(0); // Urutan tampilan
            $table->boolean('gallery_active')->default(true); // Status aktif gallery
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index untuk sort
            $table->index('sort');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_type');
    }
};