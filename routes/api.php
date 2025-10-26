<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleTypeController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\UnitTypeController;
use App\Http\Controllers\API\CommercialController;
use App\Http\Controllers\API\SlideshowController;
use App\Http\Controllers\API\SeoController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ModulController;

// Public API routes for Nuxt 4 (Read-Only)
// No authentication required - all endpoints are public
Route::prefix('v1')->group(function () {
    
    // Articles
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::get('/articles/slug/{slug}', [ArticleController::class, 'showBySlug']);
    
    // Article Types
    Route::get('/article-types', [ArticleTypeController::class, 'index']);
    Route::get('/article-types/{id}', [ArticleTypeController::class, 'show']);
    
    // Unit Types
    Route::get('/unit-types', [UnitTypeController::class, 'index']);
    Route::get('/unit-types/{id}', [UnitTypeController::class, 'show']);
    Route::get('/unit-types/slug/{slug}', [UnitTypeController::class, 'showBySlug']);
    
    // Commercial
    Route::get('/commercials', [CommercialController::class, 'index']);
    Route::get('/commercials/{id}', [CommercialController::class, 'show']);
    Route::get('/commercials/slug/{slug}', [CommercialController::class, 'showBySlug']);
    
    // Slideshow
    Route::get('/slideshows', [SlideshowController::class, 'index']);
    
    // SEO
    Route::get('/seo', [SeoController::class, 'index']);
    Route::get('/seo/{id}', [SeoController::class, 'show']);
    Route::get('/seo/page/{page}', [SeoController::class, 'getByPage']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    
    // Modul
    Route::get('/moduls', [ModulController::class, 'index']);
});

/*
 * Note:
 * - API ini HANYA untuk Nuxt 4 consumption (read-only, public access)
 * - Admin login & CRUD dilakukan via Laravel web (Livewire)
 * - Tidak ada authentication/token di API ini
 */