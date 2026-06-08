<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class BackupMonitorController extends Controller
{
    public function index()
    {
        return view('backup-monitor.index');
    }
}