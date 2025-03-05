<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function radius(){

        $lok_site = DB::table('lokasi_presensi')->where('id',1)->first();
        
        return view('settings.lokasi.radius',compact('lok_site'));
    }

    public function updateRadius(Request $request) {
        $lokasi_presensi = $request->lokasi_presensi;
        $radius = $request->radius;
        $nama_lokasi = $request->nama_lokasi;

        $update = DB::table('lokasi_presensi')->where('id',1)->update([
            'lokasi_presensi' => $lokasi_presensi,
            'radius'=>$radius,
            'nama_lokasi'=>$nama_lokasi
        ]);

        if($update){
            return Redirect::back()->with(['success'=>'Data Berhasil di Update']);
        }else {
            return Redirect::back()->with(['success'=>'Data Gagal di Update']);
        }
    }

    public function jamKerja(){
        return view('settings.jamKerja');
    }
}
