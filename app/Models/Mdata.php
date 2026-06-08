<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mdata extends Model {
    public function tambahBackup($id, $nama, $channel){
        $dt = DB::insert("INSERT INTO backup VALUES('$id', '$nama', '$channel', NOW())");
        return $dt;
    }

    public function tambahTransaksi($idx, $id, $waktux, $nominalx, $jenisx, $deskripsix){
        $dt = DB::insert("INSERT INTO backup_transaksi VALUES('$idx', '$id', '$waktux', '$nominalx', '$jenisx', '$deskripsix')");
        return $dt;
    }

    // --- FITUR RESTORE BARU ---

    // Mengambil semua daftar backup diurutkan dari yang terbaru
    public function bacaBackup() {
        $dt = DB::select("SELECT * FROM backup ORDER BY waktu DESC");
        return count($dt) > 0 ? $dt : false;
    }

    // Mengambil rincian transaksi berdasarkan id_backup tertentu
    public function bacaDetailBackup($id_backup) {
        $dt = DB::select("SELECT * FROM backup_transaksi WHERE id_backup = ? ORDER BY tgl_jam ASC", [$id_backup]);
        return count($dt) > 0 ? $dt : false;
    }
}