<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
 public function index()
    
    {  
        $hariIni = date("Y-m-d");
        $bulanIni = date("m") * 1; //1 atau Januari
        $tahunIni = date('Y'); //2025
        $jam = date("H:i:s"); // 16:20:25
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $presensiHariIni = DB::table('presensi')->where('nrp',$nrp)->where('tgl_presensi',$hariIni)->first();
        $historiBulanIni = DB::table('presensi')
            
            ->where('nrp', $nrp)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunIni . '"')
            ->orderBy('tgl_presensi')
            ->get();
        
            $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nrp) as totHadir, SUM(IF(jam_in > "06:50",1,0)) as totLate' )
            ->where('nrp', $nrp)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunIni . '"')
            ->first();

        $namaBulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November","Desember"];
        
        return view("dashboard.dashboard", compact('presensiHariIni' , 'historiBulanIni', 'namaBulan', 'bulanIni', 'tahunIni', 'rekapPresensi'));
    }

    public function dashboardadmin(){
        $totalUsers = DB::table('karyawan')->count();
        $hariIni = date("Y-m-d");
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nrp) as totHadir, SUM(IF(jam_in > "06:50",1,0)) as totLate' )
            ->where('tgl_presensi',$hariIni)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekapPresensi', 'totalUsers'));
    }
}
