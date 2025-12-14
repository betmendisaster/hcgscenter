<form action="/panel/karyawan/{{ $karyawan->nrp }}/update" method="POST" id="frmKaryawan" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M15 8l2 0" />
                        <path d="M15 12l2 0" />
                        <path d="M7 16l10 0" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nrp }}" class="form-control" placeholder="NRP" name="nrp"
                    id="nrp" readonly>
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nama }}" class="form-control" placeholder="Nama Lengkap"
                    name="nama" id="nama">
            </div>
            {{-- KODE_JABT --}}
            <div class="row ">
                <div class="col-12">
                    <select name="kode_dept" id="kode_dept" class="form-select">
                        <option value="">Department</option>
                        @foreach ($department as $d)
                            <option {{ $karyawan->kode_dept == $d->kode_dept ? 'selected' : '' }}
                                value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Area Presensi --}}
            <div class="input-icon mb-3 mt-3">
                <div class="row ">
                    <div class="col-12">
                        <select name="kode_cabang" id="kode_cabang" class="form-select">
                            <option value="">Area Presensi</option>
                            @foreach ($cabang as $d)
                                <option {{ $karyawan->kode_cabang == $d->kode_cabang ? 'selected' : '' }}
                                    value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="input-icon mb-3 mt-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                        <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                        <path d="M12 12l0 .01" />
                        <path d="M3 13a20 20 0 0 0 18 0" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->jabatan }}" class="form-control"
                    placeholder="Jabatan / Posisi" name="jabatan" id="jabatan">
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                        <path d="M11 4h2" />
                        <path d="M12 17v.01" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->telp }}" class="form-control" placeholder="No. Telp"
                    name="telp" id="telp">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-label">Foto Karyawan</div>
                        <input type="file" name="foto" class="form-control">
                        <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
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
        </div>
</form>
