@extends('layouts.absensi')
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
            <div class="flex justify-around w-full bg-white shadow-md rounded-t-lg py-2">
                <div class="flex flex-col items-center cursor-pointer">
                    <h2 class="text-black text-base font-bold">Adhy Wira Pratama</h2>
                    <p class="text-black">IT</p>
                </div>
                <div class="flex flex-col items-center mr-8">
                    <p class="text-md font-bold">Today</p>
                    <p class="text-xs" id="time">--:--</p>
                    <p class="text-xs" id="date">--/--/----</p>
                </div>
            </div>
            <div class="flex justify-around w-full bg-slate-300 shadow-md rounded-b-lg py-2">
                <div class="flex flex-col items-center cursor-pointer hover:text-teal-500 transition duration-300 ">
                    <h2 class="text-black text-sm font-bold">Status Bugar Selamat</h2>
                    <i class="fas fa-sign-out-alt"></i>
                    {{-- <p class="text-sm">{disini adalah status bugar hari ini}</p> --}}
                </div>

                <div class="flex flex-col items-center cursor-pointer hover:text-teal-500 transition duration-300 ">
                    <h2 class="text-black text-sm font-bold">Input</h2>
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </div>

            <!-- lokasi-->
            <div
                class="bg-white text-gray-800 rounded-b-lg p-2 flex items-center justify-center w-full mx-1 shadow-md mt-3">
                <input type="text" id="lokasi">
            </div>
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
            {{-- button take absen --}}
            <div class="bg-slate-300 text-gray-800 rounded-b-lg p-1 flex items-center justify-center w-full mx-1 shadow-md">
                @if ($cek > 0)
                    <button
                        class="bg-white text-black rounded-lg p-1 flex flex-col items-center w-1/5 mx-1 cursor-pointer hover:bg-red-800 transition duration-300 shadow-md hover:text-white"
                        id="takeabsen"><i class="fa-solid fa-camera"></i>Absen Pulang</button>
                @else
                    <button
                        class="bg-white text-black rounded-lg p-1 flex flex-col items-center w-1/5 mx-1 cursor-pointer hover:bg-green-800 transition duration-300 shadow-md hover:text-white"
                        id="takeabsen"><i class="fa-solid fa-camera"></i>Absen Masuk</button>
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
        <script>
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
        </script>
    </div>
@endsection
@push('myscript')
    <script>
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
            var lokasi_site = "{{ $lok_site->lokasi_presensi }}";
            var lok = lokasi_site.split(",");
            var lat_site = lok[0];
            var long_site = lok[1];
            var radius = {{ $lok_site->radius }};


            // var polygon = L.polygon([
            //     [-3.0753733, 115.1296133],
            //     [-3.077101, 115.133371],
            //     [-3.079351, 115.130937],
            //     [-3.078656, 115.130097]
            // ]).addTo(map);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
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
                            footer: '<a href="#">Hubungi Support</a>'
                        })

                    }
                }
            });
        });
    </script>
@endpush
