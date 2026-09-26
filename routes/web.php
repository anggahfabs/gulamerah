<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes (Gumer - Agro-Industrial Brown Sugar Factory)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [HomeController::class, 'products'])->name('public.products');
Route::get('/produk/{slug}', [HomeController::class, 'productDetail'])->name('public.products.show');
Route::get('/layanan-maklon', [HomeController::class, 'services'])->name('public.services');
Route::get('/standar-mutu', [HomeController::class, 'certifications'])->name('public.certifications');
Route::get('/fasilitas-pabrik', [HomeController::class, 'galleries'])->name('public.galleries');
Route::get('/edukasi', [HomeController::class, 'articles'])->name('public.articles');
Route::get('/edukasi/{slug}', [HomeController::class, 'articleDetail'])->name('public.articles.show');
Route::get('/kontak', [HomeController::class, 'contact'])->name('public.contact');

// Multi-language Locale Switcher (ID / EN)
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->forever('gumer_locale', $locale));
    }
    return redirect()->back();
})->name('lang.switch');

// Form Actions
Route::post('/rfq-submit', [HomeController::class, 'submitRfq'])->name('public.rfq.submit');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('public.subscribe');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin CMS Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Products & Variants & Price Tiers
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);

    // B2B & Maklon Services
    Route::resource('services', ServiceController::class)->except(['create', 'show', 'edit']);

    // Certifications & Legalities
    Route::resource('certifications', CertificationController::class)->except(['create', 'show', 'edit']);

    // Factory Galleries
    Route::resource('galleries', GalleryController::class)->except(['create', 'show', 'edit']);

    // Articles & Education
    Route::resource('articles', ArticleController::class);

    // B2B RFQ Inquiries
    Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'destroy']);
    Route::patch('inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');

    // Subscribers
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('subscribers/export', [SubscriberController::class, 'exportCsv'])->name('subscribers.export-csv');
    Route::get('subscribers/export-csv', [SubscriberController::class, 'exportCsv'])->name('subscribers.export');

    // Settings & Hero
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
