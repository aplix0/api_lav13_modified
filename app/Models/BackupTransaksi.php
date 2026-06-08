<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupTransaksi extends Model
{
    protected $table = 'backup_transaksi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_backup',
        'tgl_jam',
        'nominal',
        'jenis',
        'uraian',
    ];

    protected $casts = [
        'tgl_jam' => 'datetime',
        'nominal' => 'float',
    ];

    public function backup()
    {
        return $this->belongsTo(Backup::class, 'id_backup', 'id');
    }
}