<!-- Modal In -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center" id="imageModalIn" style="display: none;">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full mx-auto mt-20">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">
                Foto Absen Masuk Hari ini
            </h3>
            <button class="text-gray-500 hover:text-gray-700" id="closeModalBtnIn">
                <i class="fas fa-times">
                </i>
            </button>
        </div>
        <div class="p-4">
            @if ($presensiHariIni != null)
                @php
                    $path = Storage::url('uploads/absensi/' . $presensiHariIni->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="" class="w-full h-auto" height="400">
            @else
                <img alt="A placeholder image with dimensions 600x400 pixels, showing a simple gray background with the text '600x400' in the center"
                    class="w-full h-auto" height="400" src="{{ asset('assets/img/loader.gif') }}" width="600" />
            @endif
        </div>
    </div>
</div>

<!-- Modal Out -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center" id="imageModalOut"
    style="display: none;">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-md w-full mx-auto mt-20">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">
                Foto Absen Pulang Hari ini
            </h3>
            <button class="text-gray-500 hover:text-gray-700" id="closeModalBtnOut">
                <i class="fas fa-times">
                </i>
            </button>
        </div>
        <div class="p-4">
            @if ($presensiHariIni != null && $presensiHariIni->jam_out != null)
                @php
                    $path = Storage::url('uploads/absensi/' . $presensiHariIni->foto_out);
                @endphp
                <img src="{{ url($path) }}" alt="" class="w-full h-auto" height="400">
            @else
                <img alt="A placeholder image with dimensions 600x400 pixels, showing a simple gray background with the text '600x400' in the center"
                    class="w-full h-auto" height="400" src="{{ asset('assets/img/loader.gif') }}" width="600" />
            @endif
        </div>
    </div>
</div>

{{-- Modal Hasil Absensi --}}
<!-- Modal -->
<div id="hasilAbsen"
    class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center invisible opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-96 overflow-y-auto">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="text-xl font-semibold">Data Presensi Bulan Ini</h3>
            <button id="closeHasilAbsen" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">
                            Tanggal</th>
                        <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">
                            Status</th>
                        <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">
                            Jam Masuk</th>
                        <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">
                            Jam Pulang</th>
                    </tr>
                </thead>
                @foreach ($historiBulanIni as $d)
                    <tbody>

                        <tr>

                            <td class="py-2 px-4 border-b border-gray-300">
                                {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">Hadir/Tidak</td>
                            <td class="py-2 px-4 border-b border-gray-300">
                                {{ $d->jam_in }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">
                                {{ $presensiHariIni != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}
                            </td>
                        </tr>

                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
{{-- End Hasil Absensi --}}

<script>
    // Modal Hasil Absen

    document.getElementById('openHasilAbsen').addEventListener('click', function() {
        const modalHasilAbsen = document.getElementById('hasilAbsen');
        modalHasilAbsen.classList.remove('invisible', 'opacity-0');
        modalHasilAbsen.classList.add('visible', 'opacity-100');
    });

    document.getElementById('closeHasilAbsen').addEventListener('click', function() {
        const modalHasilAbsen = document.getElementById('hasilAbsen');
        modalHasilAbsen.classList.remove('visible', 'opacity-100');
        modalHasilAbsen.classList.add('invisible', 'opacity-0');
    });
    // Modal in Script 
    const openModalBtnIn = document.getElementById('openModalBtnIn');
    const closeModalBtnIn = document.getElementById('closeModalBtnIn');
    const imageModalIn = document.getElementById('imageModalIn');

    openModalBtnIn.addEventListener('click', () => {
        imageModalIn.style.display = 'flex';
    });

    closeModalBtnIn.addEventListener('click', () => {
        imageModalIn.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === imageModalIn) {
            imageModalIn.style.display = 'none';
        }
    });
    // End Modal in

    // Modal out Script 
    const openModalBtnOut = document.getElementById('openModalBtnOut');
    const closeModalBtnOut = document.getElementById('closeModalBtnOut');
    const imageModalOut = document.getElementById('imageModalOut');

    openModalBtnOut.addEventListener('click', () => {
        imageModalOut.style.display = 'flex';
    });

    closeModalBtnOut.addEventListener('click', () => {
        imageModalOut.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === imageModalOut) {
            imageModalOut.style.display = 'none';
        }
    });
    // End Modal out
</script>
