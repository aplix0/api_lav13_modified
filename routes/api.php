<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BackupController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cekstatus', [BackupController::class, 'status']);

Route::post('/backup', [BackupController::class, 'store']);

Route::get('/daftar_backup', [BackupController::class, 'index']);
Route::post('/detail_backup', [BackupController::class, 'detail']);
Route::get('/ringkasan_backup', [BackupController::class, 'summary']);

Route::get('/backup', [BackupController::class, 'index']);
Route::get('/backup/{idbackup}', [BackupController::class, 'detail']);
Route::get('/backup-summary', [BackupController::class, 'summary']);