@extends('layouts.absensi')
@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
            <h1 class="text-3xl font-bold mb-2">Histori Presensi</h1>
            <h2 class="text-2xl font-bold mb-4">Cari berdasarkan Bulan dan Tahun</h2>
            <form id="searchForm">
                <div class="mb-4">
                    <label for="bulan" class="block text-gray-700 font-medium mb-2">Bulan</label>
                    <select id="bulan" name="bulan"
                        class="block w-full bg-gray-100 border border-gray-300 rounded-lg py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                        {{-- <option value="">Bulan</option> --}}
                        {{-- <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $namaBulan[$i] }} --}}
                        {{-- cek bulan sekarang agar ter select berdasarkan bulan saat ini --}}
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $namaBulan[$i] }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tahun" class="block text-gray-700 font-medium mb-2">Tahun</label>
                    <select id="tahun" name="tahun"
                        class="block w-full bg-gray-100 border border-gray-300 rounded-lg py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        @php
                            $tahunStart = 2024;
                            $tahunNow = date('Y');
                        @endphp
                        @for ($tahun = $tahunStart; $tahun <= $tahunNow; $tahun++)
                            <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-end">
                    <button id="getData"
                        class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- <!-- Modal -->
    <div id="searchModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4">Search Results</h2>
            <p id="modalContent" class="mb-4"></p>
            <div class="flex justify-end">
                <button id="closeModal"
                    class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:shadow-outline">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            document.getElementById('modalContent').innerText = `You searched for: ${month} ${year}`;
            document.getElementById('searchModal').classList.remove('hidden');
            document.getElementById('searchModal').classList.add('flex');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('searchModal').classList.add('hidden');
            document.getElementById('searchModal').classList.remove('flex');
        });
    </script> --}}
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#getData").click(function(e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type: 'POST',
                    url: '/getHistori',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                    },
                    cache: false,
                    success: function(respond) {
                        $("showHistori").html(respond);
                    }
                });
            });
        });
    </script>
@endpush
