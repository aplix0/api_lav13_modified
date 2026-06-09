<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('backup-monitor', function () {
    return true;
});