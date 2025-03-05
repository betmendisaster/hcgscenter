<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create(){
        
        // validasi absen untuk absen pulang
        $today = date("Y-m-d");
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $cek = DB::table('presensi')->where('tgl_presensi', $today)->where('nrp', $nrp)->count();
        $lok_site = DB::table('lokasi_presensi')->where('id',1)->first();
        return view('layouts.presensi.create', compact('cek','lok_site'));
    }

    public function store (Request $request){
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
         
        // LOKASI 1
        $lok_site = DB::table('lokasi_presensi')->where('id',1)->first();
        $lok = explode(",",$lok_site->lokasi_presensi);
        $latitudeSite = $lok[0];
        $longitudeSite = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiUser = explode("," , $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak  = $this->distance($latitudeSite, $longitudeSite, $latitudeUser, $longitudeUser);
        $radius = round($jarak['meters']);


        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nrp', $nrp)->count();
        if($cek >0){
            $ket = "out";
        }else {
            $ket = "in";
        }
        $image = $request->image;

        // mengubah folder default ada di config/filesystems.php
        $folderPath = "uploads/absensi/";
        $formatName = $nrp . "-" . $tgl_presensi ."-". $ket;
        $image_parts = explode(";base64" ,$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
       
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nrp', $nrp)->count();
        if($radius > $lok_site->radius){
            echo "error|Maaf anda berada diluar radius absensi, jarak anda adalah ".$radius." Meter dari lokasi absensi|radius";
        }else {
            if($cek > 0){
                $data_pulang= [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi',$tgl_presensi)->where('nrp',$nrp)->update($data_pulang); 
                if ($update) {
                    echo "success|Terimakasih, Selamat Beristirahat, Hati - Hati di Jalan~|out";
                    Storage::put($file, $image_base64);
                }else {
                    echo "error|Maaf absen gagal, silahkan hubungi tim IT|out";
                }
            }else {
                $data = [
                    'nrp' => $nrp,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
            ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih, Selamat Bekerja~|in";
                    Storage::put($file, $image_base64);
                }else {
                    echo "error|Maaf absen gagal, silahkan hubungi tim IT|in";
                }
            
            }
        }
    
    }
    // untuk menghitung jarak titik koordinat absensi
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    // Update Profile Karyawan
    public function editProfile(){
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $karyawan = DB::table('karyawan')->where('nrp', $nrp)->first();
        return view('layouts.presensi.editProfile', compact('karyawan'));

    }
    // $folderPath = "uploads/absensi/";
    // $formatName = $nrp . "-" . $tgl_presensi ."-". $ket;
    // $image_parts = explode(";base64" ,$image);
    // $image_base64 = base64_decode($image_parts[1]);
    // $fileName = $formatName . ".png";
    // $file = $folderPath . $fileName;
    public function updateProfile(Request $request){
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $nama = $request->nama;
        $telp = $request->telp;
        $foto = $request->foto;
        $password = Hash::make($request->password);
    

     // Update foto

    $karyawan = DB::table('karyawan')->where('nrp', $nrp)->first();
    if ($request->hasFile('foto')){
        $foto = $nrp."." .$nama. ".".$request->file('foto')->getClientOriginalExtension();
    } else {
        $foto = $karyawan->foto;
    }


    // query data yg akan di update
    if (empty($request->password)){
        $data = [
            'nama' => $nama,
            'telp' => $telp,
            'foto' => $foto
        ];
    } else {
        $data = [
            'nama' => $nama,
            'telp' => $telp,
            'foto' => $foto,
            'password' => $password
        ];
    }
    
    // query ganti foto
    if (empty($request->foto)){
        $data = [
            'nama' => $nama,
            'telp' => $telp,
            'foto' => $foto
        ];
    } else {
        $data = [
            'nama' => $nama,
            'telp' => $telp,
            'foto' => $foto,
            'password' => $password
        ];
    }
    $update = DB::table('karyawan')->where('nrp', $nrp)->update($data);
    if($update){
        if($request->hasFile('foto')){
            $folderPath = "uploads/karyawan/fotoProfile/";
            $request->file('foto')->storeAs($folderPath, $foto);
        }
        return Redirect::back()->with(['success' => 'Profile berhasil di Upadate']);
    }else {
        return Redirect::back()->with(['error' => 'Profile gagal di Update']);
    }

}

    public function histori(){
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        
        return view('layouts.presensi.histori', compact('namaBulan'));
    }

    // public function getHistori(Request $request){
    //     $bulan = $request->bulan;
    //     $tahun = $request->tahun;
    //     $nik = Auth::guard('karyawan')->user()->nik;

    //     $histori = DB::table('presensi')
    //     ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
    //     ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
    //     ->whereRaw('nik',$nik)
    //     ->orderBy('tgl_presensi')
    //     ->get();

    //     return view('presensi.getHistori', compact('histori'));
    // }

    public function izin(){

        return  view('layouts.presensi.izin');
    }

    // monitoring contr
    public function monitoring(){
        return view ('layouts.presensi.monitoring');
    }

    public function getPresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama','nama_dept')
        ->join('karyawan','presensi.nrp','=','karyawan.nrp')
        ->join('department','karyawan.kode_dept','=','department.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('layouts.presensi.getPresensi',compact('presensi'));
    }

    public function showLocation(Request $request) {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
        ->join('karyawan','presensi.nrp','=','karyawan.nrp')
        ->first();
        return view('layouts.presensi.showLocation', compact('presensi'));
    }

    public function report(){
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama')->get();
        return view('layouts.presensi.report',compact('namaBulan','karyawan'));
    }

    public function cetakReport(Request $request){
        $nrp = $request->nrp;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $karyawan = DB::table('karyawan')->where('nrp', $nrp)
        ->join('department','karyawan.kode_dept','=','department.kode_dept')
        ->first();

        $presensi = DB::table('presensi')
        ->where('nrp', $nrp)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
        ->orderBy('tgl_presensi')
        ->get();

        if(isset($_POST['exportExcel'])){
            $nrp = $request->nrp;
            $time = date("d-M-Y H:i:s");
             // Fungsi Header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama dile exksport "hasil-export.xls"+
            header("Content-Disposition: attachment; filename=Rekap Presensi $nrp $time.xls");
            return view('layouts.presensi.cetakReportExcel',compact('bulan','tahun','namaBulan','karyawan','presensi'));
    }        
        return view('layouts.presensi.cetakReport',compact('bulan','tahun','namaBulan','karyawan','presensi'));
    }

    public function rekapReport(){
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        return view('layouts.presensi.rekapReport',compact('namaBulan'));
    }

    public function cetakRekap(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $rekap = DB::table('presensi')
        ->selectRaw('presensi.nrp,nama,
        MAX(IF(DAY(tgl_presensi) = 1,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_1,
        MAX(IF(DAY(tgl_presensi) = 2,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_2,
        MAX(IF(DAY(tgl_presensi) = 3,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_3,
        MAX(IF(DAY(tgl_presensi) = 4,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_4,
        MAX(IF(DAY(tgl_presensi) = 5,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_5,
        MAX(IF(DAY(tgl_presensi) = 6,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_6,
        MAX(IF(DAY(tgl_presensi) = 7,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_7,
        MAX(IF(DAY(tgl_presensi) = 8,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_8,
        MAX(IF(DAY(tgl_presensi) = 9,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_9,
        MAX(IF(DAY(tgl_presensi) = 10,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_10,
        MAX(IF(DAY(tgl_presensi) = 11,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_11,
        MAX(IF(DAY(tgl_presensi) = 12,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_12,
        MAX(IF(DAY(tgl_presensi) = 13,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_13,
        MAX(IF(DAY(tgl_presensi) = 14,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_14,
        MAX(IF(DAY(tgl_presensi) = 15,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_15,
        MAX(IF(DAY(tgl_presensi) = 16,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_16,
        MAX(IF(DAY(tgl_presensi) = 17,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_17,
        MAX(IF(DAY(tgl_presensi) = 18,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_18,
        MAX(IF(DAY(tgl_presensi) = 19,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_19,
        MAX(IF(DAY(tgl_presensi) = 20,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_20,
        MAX(IF(DAY(tgl_presensi) = 21,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_21,
        MAX(IF(DAY(tgl_presensi) = 22,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_22,
        MAX(IF(DAY(tgl_presensi) = 23,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_23,
        MAX(IF(DAY(tgl_presensi) = 24,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_24,
        MAX(IF(DAY(tgl_presensi) = 25,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_25,
        MAX(IF(DAY(tgl_presensi) = 26,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_26,
        MAX(IF(DAY(tgl_presensi) = 27,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_27,
        MAX(IF(DAY(tgl_presensi) = 28,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_28,
        MAX(IF(DAY(tgl_presensi) = 29,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_29,
        MAX(IF(DAY(tgl_presensi) = 30,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_30,
        MAX(IF(DAY(tgl_presensi) = 31,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) AS tgl_31')
        ->join('karyawan','presensi.nrp','=','karyawan.nrp')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->groupByRaw('presensi.nrp,nama')
        ->get();

        if(isset($_POST['exportExcel'])){
            $time = date("d-M-Y H:i:s");
             // Fungsi Header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama dile exksport "hasil-export.xls"+
            header("Content-Disposition: attachment; filename=Rekap Presensi Karyawan $time.xls");
            
        }
        return view('layouts.presensi.cetakRekapReport',compact('bulan','tahun','namaBulan','rekap'));
    }
}