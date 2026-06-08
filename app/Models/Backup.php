<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'backup';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama',
        'channel',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->hasMany(BackupTransaksi::class, 'id_backup', 'id');
    }
}