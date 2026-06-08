<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BackupMonitorController;

Route::get('/', function () {
    return redirect('/backup-monitor');
});

Route::get('/backup-monitor', [BackupMonitorController::class, 'index']);