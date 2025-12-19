@extends('layouts.layoutNoFooter')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Ganti Shift (Hari Ini: {{ $hariSekarang }}, {{ $tanggalSekarang }})</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('warning') }}
        </div>
    @endif

    <form action="/presensi/update-shift" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Shift untuk {{ $hariSekarang }}</label>
            <select name="kode_jam_kerja" class="form-select w-full" required>
                <option value="">Pilih Shift</option>
                @foreach($jamKerja as $jk)
                    <option value="{{ $jk->kode_jam_kerja }}" {{ isset($currentShift) && $currentShift->kode_jam_kerja == $jk->kode_jam_kerja ? 'selected' : '' }}>
                        {{ $jk->nama_jam_kerja }} ({{ $jk->jam_masuk }} - {{ $jk->jam_pulang }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Shift</button>
        <a href="/presensi/create" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 ml-2">Kembali</a>
    </form>
</div>
@endsection