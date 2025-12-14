@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        PT. Hasnur Riung Sinergi
                    </div>
                    <h2 class="page-title">
                        Set Jam Kerja Karyawan
                    </h2>
                </div>
                {{-- <div class="col">
                    <div class="font-weight-medium">
                        {{ $totalUsers }}
                    </div>
                    <div class="text-secondary">
                        Karyawan
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th>NRP</th>
                        <td>{{ $karyawan->nrp }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $karyawan->nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="col-6">
                    <form action="/settings/storesetJamKerja" method="POST">
                        @csrf
                        <input type="hidden" name="nrp" value="{{ $karyawan->nrp }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Shift Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Senin
                                        <input type="hidden" name="hari[]" value="Senin">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Selasa
                                        <input type="hidden" name="hari[]" value="Selasa">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rabu
                                        <input type="hidden" name="hari[]" value="Rabu">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kamis
                                        <input type="hidden" name="hari[]" value="Kamis">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jumat
                                        <input type="hidden" name="hari[]" value="Jumat">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sabtu
                                        <input type="hidden" name="hari[]" value="Sabtu">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Minggu
                                        <input type="hidden" name="hari[]" value="Minggu">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Shift Jam Kerja</option>
                                            @foreach ($jamKerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>
                    </form>

                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">Master Shift Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Jam In</th>
                                <th>Jam In</th>
                                <th>Akhir Jam In</th>
                                <th>Jam Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamKerja as $d)
                                <tr>
                                    <td>{{ $d->kode_jam_kerja }}</td>
                                    <td>{{ $d->nama_jam_kerja }}</td>
                                    <td>{{ $d->awal_jam_masuk }}</td>
                                    <td>{{ $d->jam_masuk }}</td>
                                    <td>{{ $d->akhir_jam_masuk }}</td>
                                    <td>{{ $d->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
