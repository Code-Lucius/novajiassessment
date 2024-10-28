<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncryptAndDecryptController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/encryptanddecrypt', [EncryptAndDecryptController::class,"encryptAndDecrypt"])->name('encodeanddecode');
Route::post('/encrypt', [EncryptAndDecryptController::class, 'encrypt'])->name('encrypt');
Route::post('/decrypt', [EncryptAndDecryptController::class, 'decrypt'])->name('decrypt');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
