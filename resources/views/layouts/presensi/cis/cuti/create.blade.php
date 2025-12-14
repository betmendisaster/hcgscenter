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
        Form Izin Cuti
    </h1>
@endsection
@section('content')
    <style>
        /* Customize Flatpickr input to fit Tailwind style */
        input.flatpickr-input {
            background-color: #f9fafb;
            /* Tailwind gray-50 */
            border-width: 1px;
            border-color: #d1d5db;
            /* Tailwind gray-300 */
            border-radius: 0.5rem;
            /* rounded-lg */
            padding-left: 2.5rem;
            /* pl-10 */
            padding-top: 0.625rem;
            /* p-2.5 */
            padding-bottom: 0.625rem;
            font-size: 0.875rem;
            /* text-sm */
            color: #111827;
            /* text-gray-900 */
            width: 100%;
            box-sizing: border-box;
        }

        input.flatpickr-input:focus {
            outline: none;
            border-color: #3b82f6;
            /* blue-500 */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
            /* focus:ring-blue-500 */
        }

        /* Adjust icon position */
        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 0.75rem;
            /* pl-3 */
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
            /* gray-500 */
            width: 1rem;
            height: 1rem;
        }

        #keterangan {
            height: 5rem !important;
        }
    </style>

    <body class=" relative min-h-screen rounded-lg bg-gradient-to-r from-blue-400/10 via-purple-500/10 to-pink-500/10">
        <form id="frmIzin" action="/presensi/cis/storeCuti"
            class="w-full max-w-lg bg-white shadow-lg rounded-lg p-4 sm:p-6 mx-auto" method="POST" novalidate>
            @csrf
            <div class="space-y-6">
                <div class="relative w-full max-w-sm input-wrapper mx-auto sm:mx-0">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input name="tgl_izin_dari" id="tgl_izin_dari" type="text" placeholder="Dari" autocomplete="off" />
                </div>
                <div class="relative w-full max-w-sm input-wrapper mx-auto sm:mx-0">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                    <input name="tgl_izin_sampai" id="tgl_izin_sampai" type="text" placeholder="Sampai"
                        autocomplete="off" />
                </div>

                <div class="relative w-full max-w-sm mx-auto sm:mx-0">
                    <input name="jml_hari" id="jml_hari" type="text" readonly
                        class="bg-gray-100 cursor-not-allowed border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Jumlah Hari" autocomplete="off" />
                </div>

                <div class="relative w-full max-w-sm mx-auto sm:mx-0">
                    <select name="kode_cuti" id="kode_cuti"
                        class="block w-full rounded-md border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Pilih Jenis Cuti</option>
                        @foreach ($masterCuti as $c)
                            <option value="{{ $c->kode_cuti }}">{{ $c->nama_cuti }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full max-w-lg mx-auto sm:mx-0">
                    <input type="text" name="keterangan" id="keterangan" placeholder="Keterangan"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <button type="button" id="submitBtn"
                        class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300 w-full max-w-sm sm:w-auto">Kirim</button>
                </div>
            </div>
        </form>
    </body>
@endsection
@push('myscript')
    <script>
        // Initialize Flatpickr on the date inputs with Indonesian locale and nice UI
        flatpickr.localize(flatpickr.l10ns.id || {
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],
            },
        });

        const tglIzinDariInput = document.getElementById('tgl_izin_dari');
        const tglIzinSampaiInput = document.getElementById('tgl_izin_sampai');
        const jmlHariInput = document.getElementById('jml_hari');
        const kodeCutiInput = document.getElementById('kode_cuti');

        flatpickr(tglIzinDariInput, {
            dateFormat: "Y-m-d",
            onChange: updateJumlahHari,
            allowInput: true,
        });

        flatpickr(tglIzinSampaiInput, {
            dateFormat: "Y-m-d",
            onChange: updateJumlahHari,
            allowInput: true,
        });

        // Function to calculate days difference inclusive
        function calculateDays(from, to) {
            const fromDate = new Date(from);
            const toDate = new Date(to);
            if (isNaN(fromDate) || isNaN(toDate)) return '';
            if (toDate < fromDate) return '';
            // Calculate difference in milliseconds, then convert to days, add 1 to include both dates
            const diffTime = toDate.getTime() - fromDate.getTime();
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays;
        }

        // Function to get day name in Indonesian
        function getDayName(dateString) {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const date = new Date(dateString);
            if (isNaN(date)) return '';
            return days[date.getDay()];
        }

        function updateJumlahHari() {
            const fromVal = tglIzinDariInput.value.trim();
            const toVal = tglIzinSampaiInput.value.trim();
            const days = calculateDays(fromVal, toVal);
            if (days === '') {
                jmlHariInput.value = '';
            } else {
                const fromDayName = getDayName(fromVal);
                const toDayName = getDayName(toVal);
                if (fromVal === toVal) {
                    jmlHariInput.value = `${days} hari (${fromDayName})`;
                } else {
                    jmlHariInput.value = `${days} hari (${fromDayName} - ${toDayName})`;
                }
            }
        }

        document.getElementById('submitBtn').addEventListener('click', validateAndConfirm);

        // Use localStorage key prefix to avoid conflicts
        const STORAGE_KEY_PREFIX = 'formIzin_submitted_';

        function validateAndConfirm() {
            const tglIzinDari = tglIzinDariInput.value.trim();
            const tglIzinSampai = tglIzinSampaiInput.value.trim();
            const jmlHariRaw = jmlHariInput.value.trim();
            const kodeCuti = kodeCutiInput.value.trim();
            const keterangan = document.getElementById('keterangan').value.trim();

            if (!tglIzinDari) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Dari harus diisi',
                    text: 'Silakan pilih tanggal mulai izin terlebih dahulu.',
                });
                return;
            }

            if (!tglIzinSampai) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal Sampai harus diisi',
                    text: 'Silakan pilih tanggal akhir izin terlebih dahulu.',
                });
                return;
            }

            if (!kodeCuti) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kategori Cuti harus diisi',
                    text: 'Silakan pilih kateogri cuti terlebih dahulu.',
                });
                return;
            }

            // Extract number of days from jmlHariInput (which includes day names)
            const jmlHari = parseInt(jmlHariRaw);
            if (isNaN(jmlHari) || jmlHari < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Hari tidak valid',
                    text: 'Tanggal Sampai harus sama atau lebih besar dari Tanggal Dari.',
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

            // Check if data for this date range was already submitted
            const key = STORAGE_KEY_PREFIX + tglIzinDari + '_' + tglIzinSampai;
            if (localStorage.getItem(key)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data sudah dikirim',
                    text: 'Anda sudah mengirim data izin untuk rentang tanggal ini.',
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
                    // Mark this date range as submitted in localStorage
                    localStorage.setItem(key, 'submitted');
                    document.getElementById('frmIzin').submit();
                }
            });
        }
    </script>
@endpush
