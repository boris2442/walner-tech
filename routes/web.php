<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use Inertia\Inertia;
use App\Http\Controllers\Frontend\RessourceController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Auth\GoogleController;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
// Redirection vers Google
Route::get('auth/google', [GoogleController::class, 'redirect']);

// Callback après login Google
Route::get('auth/google/callback', [GoogleController::class, 'callback']);
//Route::get('/home', [HomeController::class, 'index'])->name('home.page');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/ressources/cgu', [RessourceController::class, 'cgu'])->name('ressources.cgu');
Route::get('/ressources/confidentialite', [RessourceController::class, 'politiqueDeConfidentialite'])->name('ressources.policy');
Route::get('/ressources/legales', [RessourceController::class, 'mentionsLegales'])->name('ressources.notice');
Route::get('/ressources/refundpolicy', [RessourceController::class, 'noRemboursement'])->name('ressources.noRemboursement');

Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

// Backend routes
// Categories create
Route::prefix('/categories')->group(function () {


    // Categories create
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('', [CategoryController::class, 'index'])->name('categories.index');
});

// Products routes
// Liste tous les produits
Route::get('/products', [ProductController::class, 'index'])->name('products');
// Groupe pour le backend (optionnel : middleware auth + admin)
Route::prefix('admin')->group(function () {



    // Formulaire création produit
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');

    // Stockage nouveau produit
    Route::post('/products/store', [ProductController::class, 'store'])->name('admin.products.store');

    // Formulaire édition produit
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');

    // Mise à jour produit
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');

    // Suppression produit
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});
// Route::middleware('auth')->post('/like/{product}', [LikeController::class, 'toggle']);

// Route::middleware('auth')->group(function() {
//     Route::post('/like/{product}', [LikeController::class, 'toggle']);
// });

// Route::post('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//page not found

// Page 404 personnalisée
Route::fallback(function () {
    return Inertia::render('Frontend/NotFound');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

