<!-- Ini adalah partial view, bukan HTML lengkap. Pastikan dimuat ke dalam modal. -->

<div class="container-fluid">
    <!-- Kolom Atas: Peta Lokasi -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Lokasi Presensi</h5>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Bawah: Informasi Presensi -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Presensi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>NRP:</strong></div>
                        <div class="col-sm-8">{{ $presensi->nrp }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nama:</strong></div>
                        <div class="col-sm-8">{{ $presensi->nama }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tanggal Presensi:</strong></div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($presensi->tgl_presensi)->format('d-m-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nama Lokasi (IN):</strong></div>
                        <div class="col-sm-8">{{ $presensi->nama_lokasi ?? 'Tidak Diketahui' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Jam Masuk:</strong></div>
                        <div class="col-sm-8">{{ $presensi->jam_in ?? 'Tidak Ada' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Foto (IN):</strong></div>
                        <div class="col-sm-8">
                            @if($presensi->foto_in)
                                <img src="{{ asset('storage/uploads/absensi/' . $presensi->foto_in) }}" alt="Foto IN" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi OUT: Hanya tampil jika ada data OUT -->
                    @if($presensi->jam_out && $presensi->lokasi_out)
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Jam Keluar:</strong></div>
                            <div class="col-sm-8">{{ $presensi->jam_out }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Nama Lokasi (OUT):</strong></div>
                            <div class="col-sm-8">{{ $presensi->nama_lokasi ?? 'Tidak Diketahui' }}</div> <!-- Jika nama lokasi sama, bisa gunakan yang sama atau tambah logika -->
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Foto (OUT):</strong></div>
                            <div class="col-sm-8">
                                @if($presensi->foto_out)
                                    <img src="{{ asset('storage/uploads/absensi/' . $presensi->foto_out) }}" alt="Foto OUT" class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk inisialisasi peta -->
<script>
    // Parse lokasi IN
    var lokasiIn = "{{ $presensi->lokasi_in }}";
    var latitudeIn = null, longitudeIn = null;
    if (lokasiIn) {
        var lokIn = lokasiIn.split(",");
        latitudeIn = parseFloat(lokIn[0]);
        longitudeIn = parseFloat(lokIn[1]);
    }

    // Parse lokasi OUT (jika ada)
    var lokasiOut = "{{ $presensi->lokasi_out }}";
    var latitudeOut = null, longitudeOut = null;
    if (lokasiOut) {
        var lokOut = lokasiOut.split(",");
        latitudeOut = parseFloat(lokOut[0]);
        longitudeOut = parseFloat(lokOut[1]);
    }

    // Inisialisasi peta
    if (latitudeIn || latitudeOut) {
        // Tentukan pusat peta: Prioritas IN, jika tidak ada gunakan OUT
        var centerLat = latitudeIn || latitudeOut;
        var centerLng = longitudeIn || longitudeOut;
        var map = L.map('map').setView([centerLat, centerLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker untuk IN (jika ada)
        if (latitudeIn && longitudeIn) {
            var markerIn = L.marker([latitudeIn, longitudeIn]).addTo(map);
            var circleIn = L.circle([latitudeIn, longitudeIn], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
            markerIn.bindPopup("<b>{{ $presensi->nama }}</b><br>Lokasi Presensi IN").openPopup();
        }

        // Marker untuk OUT (jika ada)
        if (latitudeOut && longitudeOut) {
            var markerOut = L.marker([latitudeOut, longitudeOut], {icon: L.icon({iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png', iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34]})}).addTo(map); // Marker biru untuk OUT
            var circleOut = L.circle([latitudeOut, longitudeOut], {
                color: 'blue',
                fillColor: '#03f',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
            markerOut.bindPopup("<b>{{ $presensi->nama }}</b><br>Lokasi Presensi OUT");
        }

        // Jika ada keduanya, fit bounds untuk menampilkan kedua marker
        if (latitudeIn && longitudeIn && latitudeOut && longitudeOut) {
            var group = new L.featureGroup([markerIn, markerOut]);
            map.fitBounds(group.getBounds());
        }
    } else {
        document.getElementById('map').innerHTML = '<p class="text-muted">Lokasi tidak tersedia.</p>';
    }
</script>