<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\BackupTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Events\BackupUpdated;

class BackupController extends Controller
{
    public function status()
    {
        return response()->json([
            'kode' => '01',
            'status' => 'API berjalan dengan baik',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_backup' => ['required', 'string', 'max:255'],
            'dtx' => ['required', 'string'],
        ], [
            'nama_backup.required' => 'Nama backup wajib diisi',
            'dtx.required' => 'Data backup wajib dikirim',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'kode' => '00',
                'status' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $namaBackup = $request->input('nama_backup');
        $dataBase64 = $request->input('dtx');
        $dataDecode = base64_decode($dataBase64, true);

        if ($dataDecode === false || trim($dataDecode) === '') {
            return response()->json([
                'kode' => '00',
                'status' => 'Data backup tidak valid',
            ], 400);
        }

        $idBackup = (string) floor(microtime(true) * 1000);
        $barisTransaksi = array_filter(explode('#', $dataDecode), function ($item) {
            return trim($item) !== '';
        });

        $berhasil = 0;
        $gagal = 0;

        try {
            DB::transaction(function () use ($idBackup, $namaBackup, $barisTransaksi, &$berhasil, &$gagal) {
                Backup::create([
                    'id' => $idBackup,
                    'nama' => $namaBackup,
                    'channel' => 'laravel',
                    'waktu' => now(),
                ]);

                foreach ($barisTransaksi as $baris) {
                    $pecah = explode('|', $baris);

                    if (count($pecah) < 5) {
                        $gagal++;
                        continue;
                    }

                    $idx = trim($pecah[0]);
                    $uraian = trim($pecah[1]);
                    $tglJam = trim($pecah[2]);
                    $nominal = trim($pecah[3]);
                    $jenis = trim($pecah[4]);

                    if ($idx === '' || $uraian === '' || $tglJam === '' || $nominal === '' || !in_array($jenis, ['+', '-'])) {
                        $gagal++;
                        continue;
                    }

                    if (!is_numeric($nominal) || (float) $nominal <= 0) {
                        $gagal++;
                        continue;
                    }

                    try {
                        BackupTransaksi::create([
                            'id' => $idBackup . '-' . $idx,
                            'id_backup' => $idBackup,
                            'tgl_jam' => $tglJam,
                            'nominal' => $nominal,
                            'jenis' => $jenis,
                            'uraian' => $uraian,
                        ]);

                        $berhasil++;
                    } catch (\Throwable $e) {
                        $gagal++;
                    }
                }
            });

            event(new BackupUpdated($idBackup));


            return response()->json([
                'kode' => '01',
                'status' => 'Proses backup berhasil',
                'id_backup' => $idBackup,
                'berhasil' => $berhasil,
                'gagal' => $gagal,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'kode' => '00',
                'status' => 'Proses backup gagal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $data = DB::table('backup as b')
            ->leftJoin('backup_transaksi as bt', 'bt.id_backup', '=', 'b.id')
            ->select(
                'b.id',
                'b.nama',
                'b.channel',
                'b.waktu',
                DB::raw('COUNT(bt.id) as total_transaksi'),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '+' THEN bt.nominal ELSE 0 END), 0) as total_pemasukan"),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '-' THEN bt.nominal ELSE 0 END), 0) as total_pengeluaran"),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '+' THEN bt.nominal ELSE -bt.nominal END), 0) as saldo")
            )
            ->groupBy('b.id', 'b.nama', 'b.channel', 'b.waktu')
            ->orderByDesc('b.waktu')
            ->get();

        return response()->json([
            'kode' => $data->count() > 0 ? '01' : '00',
            'pesan' => $data->count() > 0 ? 'Data backup ditemukan' : 'Data backup belum tersedia',
            'data' => $data,
        ], 200);
    }

    public function detail(Request $request, $idbackup = null)
    {
        $idBackup = $idbackup ?: $request->input('idbackup');

        if (!$idBackup) {
            return response()->json([
                'kode' => '00',
                'pesan' => 'ID backup wajib dikirim',
                'data' => [],
            ], 400);
        }

        $data = BackupTransaksi::query()
            ->where('id_backup', $idBackup)
            ->orderBy('tgl_jam', 'asc')
            ->get();

        return response()->json([
            'kode' => $data->count() > 0 ? '01' : '00',
            'pesan' => $data->count() > 0 ? 'Detail backup ditemukan' : 'Detail backup tidak ditemukan',
            'data' => $data,
        ], 200);
    }

    public function summary()
    {
        $data = DB::table('backup as b')
            ->leftJoin('backup_transaksi as bt', 'bt.id_backup', '=', 'b.id')
            ->select(
                DB::raw('COUNT(DISTINCT b.id) as total_backup'),
                DB::raw('COUNT(bt.id) as total_transaksi'),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '+' THEN bt.nominal ELSE 0 END), 0) as total_pemasukan"),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '-' THEN bt.nominal ELSE 0 END), 0) as total_pengeluaran"),
                DB::raw("COALESCE(SUM(CASE WHEN bt.jenis = '+' THEN bt.nominal ELSE -bt.nominal END), 0) as saldo")
            )
            ->first();

        return response()->json([
            'kode' => '01',
            'pesan' => 'Ringkasan backup ditemukan',
            'data' => $data,
        ], 200);
    }
}