<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinCisController extends Controller
{
    public function create(){
        return view('layouts.presensi.cis.izin.create');
    }

    public function storeIzin(Request $request){
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = "i";
        $keterangan = $request->keterangan;

        $bulan = date("m",strtotime($tgl_izin_dari));
        $tahun = date("Y",strtotime($tgl_izin_dari));
        $thn = substr($tahun,2,2);
        $lastIzin = DB::table('cis')
            ->whereRaw('MONTH(tgl_izin_dari)="'.$bulan.'"')
            ->whereRaw('YEAR(tgl_izin_dari)="'.$tahun.'"')
            ->orderBy('kode_izin','desc')
            ->first();

        $lastKodeIzin = $lastIzin != null ? $lastIzin->kode_izin : "";
        $format = "IZ".$bulan.$thn;
        $kode_izin = buatKode($lastKodeIzin,$format, 3);
        $data = [
            'kode_izin' => $kode_izin,
            'nrp' => $nrp,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $cekPresensi = DB::table('presensi')
        ->whereBetween('tgl_presensi',[$tgl_izin_dari,$tgl_izin_sampai]);

        $dataPresensi = $cekPresensi->get();

        if($cekPresensi->count() > 0){
            $blacklistDate = "";
            foreach($dataPresensi as $d){
                $blacklistDate .= date('d-m-Y',strtotime($d->tgl_presensi)) .",";
            }
            return redirect('/presensi/cis/izin')->with(['warning' => 'Pengajuan tidak dapat dilakukan karena anda sudah melakukan pengajuan atau sudah melakukan absensi pada tanggal,'. $blacklistDate .' . Silahkan ganti tanggal pengajuan']);
        }
        else {
            $simpan = DB::table('cis')->insert($data);

            if($simpan) {
                return redirect('/presensi/cis/izin')->with(['success' => 'Data Berhasil di Kirim']);
            } else {
                return redirect('/presensi/cis/izin')->with(['warning' => 'Data Gagal di Kirim']);
            }
        }
        
    }
    public function edit($kode_izin){
        $dataIzin = DB::table('cis')->where('kode_izin',$kode_izin)->first();
        return view('layouts.presensi.cis.izin.edit',compact('dataIzin'));
    }

    public function update($kode_izin, Request $request) {
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;

        try {
            $data = [
                'tgl_izin_dari' => $tgl_izin_dari,
                'tgl_izin_sampai' => $tgl_izin_sampai,
                'keterangan' => $keterangan
            ];

            DB::table('cis')->where('kode_izin', $kode_izin)->update($data);
            return redirect('/presensi/cis/izin')->with(['success' => 'Data Berhasil di Update']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect('/presensi/cis/izin')->with(['warning' => 'Data Gagal di Update']);
        }
        
    }
}
