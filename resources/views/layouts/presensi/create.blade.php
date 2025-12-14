@extends('layouts.layoutNoFooter')
@section('header')
    <style>
        .fotoduls,
        .fotoduls video {
            display: inline-block;
            width: 100% !important;
            height: auto !important;
            margin: auto;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }

        .jam-digital-malasngoding {
            background-color: #46577683;
            width: 100px;
        }



        .jam-digital-malasngoding p {
            color: #fff;
            font-size: 16px;
            font-size: 0.625rem;
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
    {{-- leaflet map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    {{-- leaflet JS CDN --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection


@section('content')
    <div class="pb-20">
        {{-- dashboard --}}

        <div
            class="relative flex flex-col items-center bg-white shadow-lg rounded-lg p-4 w-full max-w-xs md:max-w-md lg:max-w-lg mx-auto">
            <div class="flex justify-around w-full bg-white shadow-md rounded-t-lg py-2 text-[0.5rem] leading-tigh">
                <div class="flex flex-col ">
                    <h2 class="text-black text-base font-bold ">
                        {{ Auth::guard('karyawan')->user()->nama }}</h2>
                    <h2 class="text-black">{{ Auth::guard('karyawan')->user()->nrp }}</h2>
                    <h2 class="text-black">{{ Auth::guard('karyawan')->user()->kode_dept }}</h2>
                    <h2 class="text-black">{{ Auth::guard('karyawan')->user()->jabatan }}</h2>
                    <h2 class="text-black text-[0.7rem] font-bold">Area Absen :
                        {{ Auth::guard('karyawan')->user()->kode_cabang }}</h2>

                </div>
                <div class="flex flex-col items-center mr-8 text-[0.5rem] leading-tigh">
                    <div class="jam-digital-malasngoding">
                        <p>{{ date('D') }}</p>
                    </div>
                    {{-- <div class="jam-digital-malasngoding">
                        <p>{{ date('d/m/Y') }}</p>
                    </div> --}}
                    <div class="jam-digital-malasngoding">
                        <p id="jam"></p>
                        <p>{{ $jamKerja->nama_jam_kerja }}</p>
                        <p>Mulai Jam In : {{ date('H:i', strtotime($jamKerja->awal_jam_masuk)) }}</p>
                        <p>Akhir Jam Out : {{ date('H:i', strtotime($jamKerja->jam_pulang)) }}</p>
                        <p></p>
                    </div>
                </div>
            </div>

            {{-- <div class="flex justify-around w-full bg-slate-300 shadow-md rounded-b-lg py-2">
                <div class="flex flex-col items-center cursor-pointer hover:text-teal-500 transition duration-300 ">
                    <h2 class="text-black text-sm font-bold">Status Bugar Selamat</h2>
                    <i class="fas fa-sign-out-alt"></i>
                    <p class="text-sm">{disini adalah status bugar hari ini}</p>
                </div>

                <div class="flex flex-col items-center cursor-pointer hover:text-teal-500 transition duration-300 ">
                    <h2 class="text-black text-sm font-bold">Input</h2>
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </div> --}}


            {{-- webcam js nya --}}
            <div
                class="bg-white text-gray-800 rounded-t-lg p-2 flex items-center justify-center w-full mx-1 shadow-md mt-3">
                <div class="fotoduls"></div>
            </div>

            <div class="items-center shadow-lg rounded-lg p-4 w-full max-w-xs md:max-w-md lg:max-w-lg mx-auto">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
            <!-- lokasi-->
            <div
                class="bg-white text-gray-800 rounded-b-lg p-2 flex items-center justify-center w-full mx-1 shadow-md mt-3">
                <input type="text" id="lokasi">
            </div>
            {{-- button take absen --}}
            <div class="bg-slate-300 text-gray-800 rounded-b-lg p-1 flex items-center justify-center w-full mx-1 shadow-md">
                @if ($cek > 0)
                    <button
                        class="bg-white text-black rounded-lg p-1 flex flex-col items-center w-1/5 mx-1 cursor-pointer hover:bg-red-800 transition duration-300 shadow-md hover:text-white"
                        id="takeabsen"><i class="fa-solid fa-camera"></i>Out</button>
                @else
                    <button
                        class="bg-white text-black rounded-lg p-1 flex flex-col items-center w-1/5 mx-1 cursor-pointer hover:bg-green-800 transition duration-300 shadow-md hover:text-white"
                        id="takeabsen"><i class="fa-solid fa-camera"></i>in</button>
                @endif

            </div>


        </div>

        {{-- Notif / AUDIO MASTER --}}
        <audio id='notifikasi_in'>
            <source src="{{ asset('assets/sound/in.wav') }}" type="audio/wav">
        </audio>
        <audio id="notifikasi_out">
            <source src="{{ asset('assets/sound/out.wav') }}" type="audio/wav">
        </audio>
        <audio id="radius_sound">
            <source src="{{ asset('assets/sound/errorRadius.mp3') }}" type="audio/mpeg">
        </audio>
        {{-- <script>
            function updateTimeAndDate() {
                const now = new Date();
                const time = now.toLocaleTimeString([], {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: false // Menambahkan opsi ini untuk format 24 jam
                });
                const date = now.toLocaleDateString();
                document.getElementById("time").textContent = time;
                document.getElementById("date").textContent = date;
            }
            setInterval(updateTimeAndDate, 1000);
            updateTimeAndDate();
        </script> --}}
    </div>
@endsection
@push('myscript')
    <script>
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }

        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        var radius_sound = document.getElementById('radius_sound');

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80,
            mobileAutoAdvance: true,
            flip_horiz: true
        });
        Webcam.attach('.fotoduls');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(posisi) {
            lokasi.value = posisi.coords.latitude + ',' + posisi.coords.longitude;
            var map = L.map('map').setView([posisi.coords.latitude, posisi.coords.longitude], 15);

            // LOKASI 1
            var lokasi_site = "{{ $lok_site->lokasi_cabang }}";
            var lok = lokasi_site.split(",");
            var lat_site = lok[0];
            var long_site = lok[1];
            var radius = {{ $lok_site->radius_cabang }};


            // var polygon = L.polygon([
            //     [-3.0753733, 115.1296133],
            //     [-3.077101, 115.133371],
            //     [-3.079351, 115.130937],
            //     [-3.078656, 115.130097]
            // ]).addTo(map);

            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var marker = L.marker([posisi.coords.latitude, posisi.coords.longitude]).addTo(map);
            // RADIUS TITIK KOORDINAT LOKASI ABSEN
            var circle = L.circle([lat_site, long_site], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);

        }

        function errorCallback() {

        }

        // take absen ajax

        $("#takeabsen").click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            // lokasi ambil
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play()
                        }
                        Swal.fire({
                            title: 'Berhasil !',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        if (status[2] == "radius") {
                            radius_sound.play();
                        }
                        Swal.fire({
                            title: 'Tidak Berhasil !',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'OK',
                            footer: '<a href="/">Kembali ke Dashboard</a>'
                        })

                    }
                }
            });
        });
    </script>
@endpush
