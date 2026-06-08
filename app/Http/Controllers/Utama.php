<?php

namespace App\Http\Controllers;

use App\Models\Mdata;
use Illuminate\Http\Request;

class Utama extends Controller
{
    public function statusAPI()
    {
        // Menyiapkan data array untuk dikirim sebagai JSON
        $dtx = [
            "kode" => "01",
            "status" => "API berjalan dengan Baik"
        ];

        // Mengembalikan respons dalam format JSON dengan HTTP Status Code 200 (OK)
        return response()->json($dtx, 200);
    }

    public function backupData(Request $xyz)
    {
        $nama = $xyz->input("nama_backup");
        $dtx = base64_decode($xyz->input("dtx"));
        $id = floor(microtime(true) * 1000);
        $arr_data = explode("#", $dtx);
        $mx = new Mdata();
        $proses = $mx->tambahBackup($id, $nama, "laravel");

        if ($proses == "1") {
            $berhasil = 0;
            $gagal = 0;

            foreach ($arr_data as $k) {
                $arr_data2 = explode("|", $k);
                $idx = $arr_data2[0];
                $deskripsix = $arr_data2[1];
                $waktux = $arr_data2[2];
                $nominalx = $arr_data2[3];
                $jenisx = $arr_data2[4];

                $proses2 = $mx->tambahTransaksi($id . "-" . $idx, $id, $waktux, $nominalx, $jenisx, $deskripsix);
                $proses2 == "1" ? $berhasil++ : $gagal++;
            }

            $pesanx = ["kode" => "01", "status" => "Proses Backup Berhasil dengan Rincian ", "berhasil" => $berhasil, "gagal" => $gagal];
            $kodex = 200;
        } else {
            $pesanx = ["kode" => "00", "status" => "Proses Backup Gagal, Periksa Kembali Data Anda"];
            $kodex = 500;
        }

        return response()->json($pesanx, $kodex);
    }

    // --- FITUR RESTORE BARU ---

    public function daftarBackup()
    {
        $mx = new Mdata();
        $dtbackup = $mx->bacaBackup();

        if ($dtbackup == false) {
            return response()->json([
                "kode" => "00",
                "pesan" => "Data Backup Tidak Di Temukan"
            ], 200);
        }

        return response()->json([
            "kode" => "01",
            "pesan" => "Data Backup Di Temukan",
            "data" => $dtbackup
        ], 200);
    }

    public function detailBackup(Request $request)
    {
        $idbackup = $request->input("idbackup"); // sesuaikan parameter input mobile/client

        $mx = new Mdata();
        $dtdetail = $mx->bacaDetailBackup($idbackup);

        if ($dtdetail == false) {
            return response()->json([
                "kode" => "00",
                "pesan" => "Data Detail Backup Tidak Di Temukan"
            ], 200);
        }

        return response()->json([
            "kode" => "01",
            "pesan" => "Data Detail Backup Di Temukan",
            "data" => $dtdetail
        ], 200);
    }
}
