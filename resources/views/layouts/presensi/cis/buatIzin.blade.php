@extends('layouts.navCustom')
@section('judulHalaman')
    <a href="/">
        <button aria-label="Kembali ke menu sebelumnya"
            class="flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
            onclick="window.history.back()">
            <i class="fas fa-arrow-left text-lg">
            </i>
        </button>
    </a>
    <h1 class="text-lg font-semibold truncate">
        Form Izin
    </h1>
@endsection
@section('content')

    <body class=" relative min-h-screen rounded-lg bg-gradient-to-r from-blue-400/10 via-purple-500/10 to-pink-500/10">
        <form id="frmIzin" action="/presensi/cis/storeIzin" class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6"
            method="POST" novalidate>
            @csrf
            <div class="space-y-6">
                <div class="relative max-w-sm w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input name="tgl_izin" id="datepicker-format" datepicker datepicker-format="yyyy-mm-dd"
                        datepicker-autohide type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                        placeholder="Pilih Tanggal" autocomplete="off" />
                </div>

                <div>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Pilih salah satu</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                        <option value="c">Cuti</option>
                    </select>
                </div>

                <div>
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="Keterangan"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="submitBtn"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">Kirim</button>
                </div>
            </div>
        </form>
    </body>
@endsection
@push('myscript')
    <script>
        // Use localStorage key prefix to avoid conflicts
        const STORAGE_KEY_PREFIX = 'formIzin_submitted_';

        document.getElementById('submitBtn').addEventListener('click', validateAndConfirm);

        function validateAndConfirm() {
            const tglIzin = document.getElementById('datepicker-format').value.trim();
            const status = document.getElementById('status').value.trim();
            const keterangan = document.getElementById('keterangan').value.trim();

            if (!tglIzin) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal harus diisi',
                    text: 'Silakan pilih tanggal izin terlebih dahulu.',
                });
                return;
            }

            if (!status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Status harus dipilih',
                    text: 'Silakan pilih status izin.',
                });
                return;
            }

            if (!keterangan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Keterangan harus diisi',
                    text: 'Silakan isi keterangan izin.',
                });
                return;
            }

            // Check if data for this date was already submitted
            if (localStorage.getItem(STORAGE_KEY_PREFIX + tglIzin)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data sudah dikirim',
                    text: 'Anda sudah mengirim data izin untuk tanggal ini.',
                });
                return;
            }

            Swal.fire({
                title: 'Apakah data anda sudah benar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mark this date as submitted in localStorage
                    localStorage.setItem(STORAGE_KEY_PREFIX + tglIzin, 'submitted');
                    document.getElementById('frmIzin').submit();
                }
            });
        }
    </script>
@endpush
