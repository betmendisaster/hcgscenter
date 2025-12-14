<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class CabangController extends Controller
{
    public function index (){
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view ('settings.cabang.index', compact('cabang'));
    }


    public function update (Request $request) {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang

            ];
            DB::table('cabang')
            ->where('kode_cabang', $kode_cabang)
            ->update($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        }
    }

    public function edit (Request $request){
        $kode_cabang = $request->kode_cabang;
        $cabang = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        return view('settings.cabang.edit', compact('cabang'));
    }

    public function store (Request $request) {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang

            ];
            DB::table('cabang')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal DiSimpan']);
        }
        
    }

    public function delete($kode_cabang){
        $delete = DB::table('cabang')->where('kode_cabang', $kode_cabang)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil di Delete']);
        } else {
            return Redirect::back()->with(['warning'=>'Data Gagal di Delete']);
        }
    }
}
