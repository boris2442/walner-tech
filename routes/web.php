<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\AboutController;
use Inertia\Inertia;
use App\Http\Controllers\frontend\RessourceController;
use App\Http\Controllers\frontend\ContactController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home.page');
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/cgu', [RessourceController::class, 'cgu'])->name('ressources.cgu');
Route::get('/confidentialite', [RessourceController::class, 'politiqueDeConfidentialite'])->name('ressources.policy');
Route::get('/legales', [RessourceController::class, 'mentionsLegales'])->name('ressources.notice');
Route::get('/refundpolicy', [RessourceController::class, 'noRemboursement'])->name('ressources.noRemboursement');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
