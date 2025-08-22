<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/docs', function () {
    $path = storage_path('api-docs/api-docs.json');
    abort_unless(file_exists($path), 404);
    return response()->file($path, ['Content-Type' => 'application/json']);
})->name('l5-swagger.default.docs'); // <— nom exact attendu par l’UI