<?php


use App\Infrastructure\Controllers\DocController;
use Illuminate\Support\Facades\Route;

Route::get('docs', [DocController::class, 'index'])->name('doc.index');
Route::get('docs/swagger', [DocController::class, 'swagger'])->name('doc.swagger');
Route::get('docs/redoc', [DocController::class, 'redoc'])->name('doc.redoc');
Route::get('docs/file/{file}', [DocController::class, 'files'])->name('doc.file');
