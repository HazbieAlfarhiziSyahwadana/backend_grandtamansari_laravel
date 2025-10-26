<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleTypeController;
use App\Http\Controllers\Admin\CommercialController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SlideshowController;
use App\Http\Controllers\Admin\UnitTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\ArticleTypes\ArticleTypeIndex;
use App\Livewire\Admin\Articles\ArticleIndex;
use App\Livewire\Admin\Commercials\CommercialIndex;
use App\Livewire\Admin\Modules\ModuleIndex;
use App\Livewire\Admin\Seo\SeoIndex;
use App\Livewire\Admin\Slideshows\SlideshowIndex;
use App\Livewire\Admin\UnitTypes\UnitTypeIndex;
use App\Livewire\Admin\Users\UserIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::redirect('/dashboard', '/admin')->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::view('/', 'admin.dashboard')->name('dashboard');

        Route::middleware('can:manage-content')->group(function (): void {
            Route::get('articles', ArticleIndex::class)->name('articles.index');
            Route::resource('articles', ArticleController::class)->except(['index', 'show']);

            Route::get('article-types', ArticleTypeIndex::class)->name('article-types.index');
            Route::resource('article-types', ArticleTypeController::class)->except(['index', 'show']);

            Route::get('unit-types', UnitTypeIndex::class)->name('unit-types.index');
            Route::resource('unit-types', UnitTypeController::class)->except(['index', 'show']);

            Route::get('commercials', CommercialIndex::class)->name('commercials.index');
            Route::resource('commercials', CommercialController::class)->except(['index', 'show']);

            Route::get('slideshows', SlideshowIndex::class)->name('slideshows.index');
            Route::resource('slideshows', SlideshowController::class)->except(['index', 'show']);

            Route::get('seo', SeoIndex::class)->name('seo.index');
            Route::resource('seo', SeoController::class)->except(['index', 'show']);

            Route::get('modules', ModuleIndex::class)->name('modules.index');
            Route::resource('modules', ModuleController::class)->except(['index', 'show']);

            Route::middleware('can:manage-users')->group(function (): void {
                Route::get('users', UserIndex::class)->name('users.index');
                Route::resource('users', UserController::class)->except(['index', 'show']);
            });

            Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        });
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


