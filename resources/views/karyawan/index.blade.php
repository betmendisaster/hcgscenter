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
                        Data Karyawan
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="add-karyawan"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M16 19h6" />
                                            <path d="M19 16v6" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                        </svg>Tambah Data</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/panel/karyawan" method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                        class="form-control" placeholder="Nama Karyawan"
                                                        value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                                        <option value="">Department</option>
                                                        @foreach ($department as $d)
                                                            <option
                                                                {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}
                                                                value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NRP</th>
                                                <th>Nama</th>
                                                <th>Department</th>
                                                <th>Area Presensi</th>
                                                <th>Jabatan</th>
                                                <th>No. HP</th>
                                                <th>Foto</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $d)
                                                @php
                                                    $path = Storage::url('uploads/karyawan/fotoProfile/' . $d->foto);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                    <td>{{ $d->nrp }}</td>
                                                    <td>{{ $d->nama }}</td>
                                                    <td>{{ $d->nama_dept }}</td>
                                                    <td>{{ $d->kode_cabang }}</td>
                                                    <td>{{ $d->jabatan }}</td>
                                                    <td>{{ $d->telp }}</td>
                                                    <td>
                                                        @if (empty($d->foto))
                                                            <img src="{{ asset('assets/img/default-profile.jpg') }}"
                                                                class="avatar" alt="">
                                                        @else
                                                            <img src="{{ url($path) }}" class="avatar" alt="">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="#" class="edit btn btn-info btn-sm"
                                                                nrp="{{ $d->nrp }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                                    <path
                                                                        d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                                                </svg>
                                                            </a>
                                                            <a href="/settings/{{ $d->nrp }}/setJamKerja"
                                                                class="btn btn-success btn-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-cog">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path
                                                                        d="M12 21h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" />
                                                                    <path d="M16 3v4" />
                                                                    <path d="M8 3v4" />
                                                                    <path d="M4 11h16" />
                                                                    <path
                                                                        d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                    <path d="M19.001 15.5v1.5" />
                                                                    <path d="M19.001 21v1.5" />
                                                                    <path d="M22.032 17.25l-1.299 .75" />
                                                                    <path d="M17.27 20l-1.3 .75" />
                                                                    <path d="M15.97 17.25l1.3 .75" />
                                                                    <path d="M20.733 20l1.3 .75" />
                                                                </svg>
                                                            </a>
                                                            <form action="/panel/karyawan/{{ $d->nrp }}/delete"
                                                                method="POST" style="margin-left:5px;">
                                                                @csrf
                                                                {{-- @method('DELETE') --}}
                                                                <a class="btn btn-danger btn-sm delete-confirm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-x">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                                        <path d="M22 22l-5 -5" />
                                                                        <path d="M17 22l5 -5" />
                                                                    </svg>
                                                                </a>
                                                            </form>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL ADD DATA KARYAWAN --}}
    <div class="modal modal-blur fade" id="modal-addKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/panel/karyawan/store" method="POST" id="frmKaryawan" enctype="multipart/form-data">
                        @csrf
                        {{-- NRP --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" placeholder="NRP"
                                        name="nrp" id="nrp">
                                </div>
                            </div>
                            {{-- NAMA --}}
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Nama Lengkap"
                                    name="nama" id="nama">
                            </div>
                            {{-- DEPT --}}
                            <div class="row ">
                                <div class="col-12">
                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                        <option value="">Department</option>
                                        @foreach ($department as $d)
                                            <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Area Presensi/Cabang Presensi --}}
                        <div class="input-icon mb-3 mt-3">
                            <div class="row ">
                                <div class="col-12">
                                    <select name="kode_cabang" id="kode_cabang" class="form-select">
                                        <option value="">Area Presensi</option>
                                        @foreach ($cabang as $d)
                                            <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- JAB --}}
                        <div class="input-icon mb-3 mt-3">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                                    <path d="M12 12l0 .01" />
                                    <path d="M3 13a20 20 0 0 0 18 0" />
                                </svg>
                            </span>
                            <input type="text" value="" class="form-control" placeholder="Jabatan / Posisi"
                                name="jabatan" id="jabatan">
                        </div>
                        {{-- TELP --}}
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                                    <path d="M11 4h2" />
                                    <path d="M12 17v.01" />
                                </svg>
                            </span>
                            <input type="text" value="" class="form-control" placeholder="No. Telp"
                                name="telp" id="telp">
                        </div>
                        {{-- FOTO --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="form-label">Foto Karyawan</div>
                                    <input type="file" name="foto" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="modal-footer">
                                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UPDATE DATA KARYAWAN --}}

    <div class="modal modal-blur fade" id="modal-editKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadEditForm">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $('#add-karyawan').click(function() {
                $("#modal-addKaryawan").modal("show");
            });

            $('.edit').click(function() {
                var nrp = $(this).attr('nrp');
                $.ajax({
                    type: 'POST',
                    url: '/panel/karyawan/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nrp: nrp
                    },
                    success: function(respond) {
                        $("#loadEditForm").html(respond);
                    }
                });
                $("#modal-editKaryawan").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apakah sudah yakin ingin menghapus Data ini ?",
                    text: "Jika ya maka Data akan terhapus Permanent",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    form.submit();
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data berhasil di Hapus.",
                            icon: "success"
                        });
                    }
                });
            });

            $('#frmKaryawan').submit(function() {
                var nrp = $('#nrp').val();
                var nama = $('#nama').val();
                var kode_dept = $('#frmKaryawan').find('#kode_dept').val();
                var jabatan = $('#jabatan').val();
                var telp = $('#telp').val();
                if (nrp == "") {
                    // alert('NRP Harus diIsi');
                    Swal.fire({
                        title: "Warning!",
                        text: "NRP belum terisi",
                        icon: "warning",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#nrp').focus();
                    });

                    return false;
                } else if (nama == "") {
                    Swal.fire({
                        title: "Warning!",
                        text: "Nama belum terisi",
                        icon: "warning",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#nama').focus();
                    });

                    return false;
                } else if (kode_dept == "") {
                    Swal.fire({
                        title: "Warning!",
                        text: "Department belum terisi",
                        icon: "warning",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#kode_dept').focus();
                    });

                    return false;
                } else if (jabatan == "") {
                    Swal.fire({
                        title: "Warning!",
                        text: "Jabatan belum terisi",
                        icon: "warning",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#jabatan').focus();
                    });

                    return false;
                } else if (telp == "") {
                    Swal.fire({
                        title: "Warning!",
                        text: "No.Telp belum terisi",
                        icon: "warning",
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $('#telp').focus();
                    });

                    return false;
                }
            });
        });
    </script>
@endpush
