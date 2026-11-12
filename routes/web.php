<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DkmAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Aqiqah & Qurban Platform
|--------------------------------------------------------------------------
*/

// Public Guest Routes (No Login Required)
Route::get('/', [PublicCatalogController::class, 'index'])->name('home');

// Dedicated Anatomy Routes
Route::get('/anatomi', [PublicCatalogController::class, 'anatomyHub'])->name('anatomy.hub');
Route::get('/anatomi/{type}', [PublicCatalogController::class, 'showAnatomyPage'])->name('anatomy.show');

// Figma Presentation Showcase
Route::get('/presentation', [PublicCatalogController::class, 'figmaPresentation'])->name('presentation');
Route::get('/figma', [PublicCatalogController::class, 'figmaPresentation']);

// Live Chat & API Endpoints
Route::get('/api/hotspots/{type}', [PublicCatalogController::class, 'getHotspots'])->name('hotspots.get');
Route::get('/api/animal/{id}', [PublicCatalogController::class, 'getAnimalDetail'])->name('animal.detail');
Route::get('/api/chat/guest-token', [ChatController::class, 'issueGuestToken']);
Route::get('/api/chat/messages', [ChatController::class, 'getMessages']);
Route::post('/api/chat/send', [ChatController::class, 'sendMessage']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register-dkm', [AuthController::class, 'showRegisterDkm'])->name('register.dkm');
Route::post('/register-dkm', [AuthController::class, 'registerDkm']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Super Admin Routes
    Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
        Route::post('/dkm/{id}/approve', [SuperAdminController::class, 'approveDkm'])->name('approve');
        Route::post('/dkm/{id}/reject', [SuperAdminController::class, 'rejectDkm'])->name('reject');
        Route::post('/dkm/{id}/toggle', [SuperAdminController::class, 'toggleStatus'])->name('toggle');
    });

    // DKM Admin Routes (Enforcing Approval check)
    Route::middleware(['auth', \App\Http\Middleware\EnsureApprovedAdmin::class])->prefix('dkm')->name('dkm.')->group(function () {
        Route::get('/dashboard', [DkmAdminController::class, 'index'])->name('dashboard');
        Route::post('/animal/store', [DkmAdminController::class, 'storeAnimal'])->name('animal.store');
        Route::post('/animal/{id}/status', [DkmAdminController::class, 'updateStatus'])->name('animal.status');
        Route::delete('/animal/{id}', [DkmAdminController::class, 'deleteAnimal'])->name('animal.delete');

        // DKM Chat Inbox API
        Route::get('/api/conversations', [ChatController::class, 'getDkmConversations']);
        Route::get('/api/messages/{guestToken}', [ChatController::class, 'getDkmGuestMessages']);
        Route::post('/api/reply', [ChatController::class, 'sendDkmReply']);
    });
});
