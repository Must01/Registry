<?php

use App\Http\Controllers\RegistryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Welcome Routes
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Registry Routes
    Route::get('/registries/export-csv', [RegistryController::class, 'export'])
        ->name('registry.export');
    Route::get('/registries/export', [RegistryController::class, 'exportPage'])->name('registry.export.page');

    // registry files
    Route::resource('registry', RegistryController::class);
    Route::delete('registry/{registry}/file', [RegistryController::class, 'removeFile'])->name('registry.file.destroy');
    Route::get('registry/{registry}/download/{file}', [RegistryController::class, 'downloadFile'])->name('registry.file.download');
    Route::get('registry/{registry}/registry.file.view/{file}', [RegistryController::class, 'viewFile'])->name('registry.file.view');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
