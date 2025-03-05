<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- FavIcons --}}
    <link rel="icon" type="image/png" href={{ asset('assets/img/favicon.png') }} sizes="32x32">
    {{-- tailwindcss vite local --}}
    @vite('resources/css/app.css')
    <link href="./style.css" rel="stylesheet" />
    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <title>A3-app</title>


</head>

<body>
    @include('layouts.nav.navUser')
    {{-- CONTENT --}}
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
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                {{ $namaBulan[$i] }}
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
                        console.log(respond);
                    }
                });
            });
        });
    </script>
    {{-- END CONTENT --}}
    @include('layouts.nav.bottomNavUser')
    @include('layouts.scripts.script')
</body>

</html>
