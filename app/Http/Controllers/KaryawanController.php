<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    // public function karyawanInfo(){
    //     $totalUsers = DB::table('karyawan')->count();
    //     return view('karyawan.index', compact( 'totalUsers'));
    // }
    
    public function index(Request $request){
        
        $query = Karyawan::query();
        $query->select('karyawan.*','nama_dept');
        $query->join('department','karyawan.kode_dept','=','department.kode_dept');
        $query->orderBy('nama');
        if (!empty($request->nama_karyawan)){
            $query->where('nama','like','%' . $request->nama_karyawan .'%');
        }

        // ADA 2 KODE_DEPT, DEFINISIKAN DARI TABLE MANA 'karyawan.kode_dept'
        if (!empty($request->kode_dept)){
            $query->where('karyawan.kode_dept',  $request->kode_dept);
        }
        $karyawan = $query->paginate(10);


        $department = DB::table('department')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('karyawan.index', compact('karyawan','department', 'cabang'));
    }

    // ADD DATA KARYAWAN
    public function store(Request $request){
        $nrp = $request->nrp;
        $nama = $request->nama;
        $kode_dept = $request->kode_dept;
        $jabatan = $request->jabatan;
        $telp = $request->telp;
        $password = Hash::make('123');
        $kode_cabang = $request->kode_cabang;
                if ($request->hasFile('foto')) {
            $foto = $nrp . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nrp' => $nrp,
                'nama' => $nama,
                'kode_dept' => $kode_dept,
                'jabatan' => $jabatan,
                'telp' => $telp,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "uploads/karyawan/fotoProfile/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }

                return Redirect::back()->with(['success' =>'Data Berhasil di Simpan']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' =>'Data Gagal di Simpan']);
           
        }
    }  

    public function edit(Request $request)
    {
        $nrp = $request->nrp;
        $department = DB::table('department')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nrp',$nrp)->first();
        return view('karyawan.edit',compact('department','karyawan', 'cabang'));
    }

    public function update ($nrp, Request $request){
        $nrp = $request->nrp;
        $nama = $request->nama;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;
        $jabatan = $request->jabatan;
        $telp = $request->telp;
        // $password = Hash::make('123');
        $old_foto = $request->old_foto;
                if ($request->hasFile('foto')) {
            $foto = $nrp . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

         try {
            $data = [
                'nama' => $nama,
                'kode_dept' => $kode_dept,
                'jabatan' => $jabatan,
                'telp' => $telp,
                'foto' => $foto,
                // 'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $update = DB::table('karyawan')->where('nrp', $nrp)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "uploads/karyawan/fotoProfile/";
                    $folderPathOld = "uploads/karyawan/fotoProfile/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                    
                }
                return Redirect::back()->with(['success' =>'Data Berhasil di Update']);
            }
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' =>'Data Gagal di Update']);
           
        }
    }
    
    public function delete($nrp){
        $delete = DB::table('karyawan')->where('nrp', $nrp)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil di Delete']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal di Delete']);
        }
    }
}
