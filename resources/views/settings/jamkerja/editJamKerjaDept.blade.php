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
                        Edit Set Jam Kerja Department
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <form action="/settings/jamKerjaDept/{{ $jamKerjaDept->kode_jk_dept }}/update" method="POST">
                @csrf
                <div class="col-12">
                    <div class="row">
                        {{-- <div class="col-6">
                            <div class="form-group">
                                <select name="kode_cabang" id="kode_cabang" class="form-select">
                                    <option value="">Pilih Cabang</option>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_dept" id="kode_dept" class="form-select" disabled>
                                    <option value="">Pilih Department</option>
                                    @foreach ($department as $d)
                                        <option {{ $jamKerjaDept->kode_dept == $d->kode_dept ? 'selected' : '' }}
                                            value="{{ $d->kode_dept }}">
                                            {{ strtoupper($d->nama_dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Shift Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jamKerjaDeptDetail as $s)
                                    <tr>
                                        <td> {{ $s->hari }}
                                            <input type="hidden" name="hari[]" value="{{ $s->hari }}">
                                        </td>
                                        <td>
                                            <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                <option value="">Pilih Shift Jam Kerja</option>
                                                @foreach ($jamKerja as $d)
                                                    <option {{ $d->kode_jam_kerja == $s->kode_jam_kerja ? 'selected' : '' }}
                                                        value="{{ $d->kode_jam_kerja }}">
                                                        {{ $d->nama_jam_kerja }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
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
