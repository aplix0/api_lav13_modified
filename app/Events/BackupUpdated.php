<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BackupUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $backupId;

    public function __construct(string $backupId)
    {
        $this->backupId = $backupId;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('backup-monitor'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'backup.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'backup_id' => $this->backupId,
            'time' => now()->toDateTimeString(),
        ];
    }
}