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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>A3-app</title>

    {{-- Loader --}}
    <style>
        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #000;
            width: 40px;
            height: 40px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-text {
            margin-top: 10px;
            font-size: 1.2rem;
            color: #000;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="bg-white border-gray-200 sticky top-0 z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            @yield('judulHalaman')
            {{-- @section('judulHalaman')
                            <a href="/">
                                <button aria-label="Kembali ke menu sebelumnya"
                                    class="flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                                    onclick="window.history.back()">
                                    <i class="fas fa-arrow-left text-lg">
                                    </i>
                                </button>
                            </a>
                            <h1 class="text-lg font-semibold truncate">
                                Judul Halaman
                            </h1>
                        @endsection --}}
            {{-- <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button"
                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    @if (!empty(Auth::guard('karyawan')->user()->foto))
                        @php
                            $path = Storage::url(
                                'uploads/karyawan/fotoProfile/' . Auth::guard('karyawan')->user()->foto,
                            );
                        @endphp
                        <img class="object-cover w-8 h-8 rounded-full" src="{{ url($path) }}"
                            alt="Profile picture of Adhy Wira Pratama" />
                    @else
                        <img class="w-8 h-8 rounded-full" src="{{ asset('assets/img/default-profile.jpg') }}"
                            alt="Profile picture of Adhy Wira Pratama" />
                    @endif

                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span
                            class="block text-sm text-gray-900 dark:text-white">{{ Auth::guard('karyawan')->user()->nama }}</span>
                        <span
                            class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::guard('karyawan')->user()->nrp }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="/"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="/editProfile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                        </li>
                        <li>
                            <a href="/proseslogout"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Log
                                out</a>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </nav>


    @yield('header')
    {{-- Main Hero --}}
    <div class="appCapsule">
        @yield('content')
    </div>
    @include('layouts.scripts.script')

    <script>
        window.addEventListener('load', function() {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        });
    </script>
</body>

</html>
