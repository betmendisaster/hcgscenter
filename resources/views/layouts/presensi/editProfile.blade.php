@extends('layouts.absensi')

@section('content')
    <div class="relative flex flex-col items-center bg-white shadow-lg rounded-lg p-4 w-full max-w-xs md:max-w-md lg:max-w-lg mx-auto pb-20"
        style="display: none;" id="content">
        <div>
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ $messagesuccess }}</span>
                </div>
            @endif
            @if (Session::get('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">{{ $messageerror }}</span>
                </div>
            @endif
        </div>
        <h1 class="text-2xl font-bold text-gray-700 mb-4 self-start">Edit Profile</h1>
        <form id="profileForm" action="/presensi/{{ $karyawan->nrp }}/updateProfile" method="POST"
            enctype="multipart/form-data" class="w-full">
            @csrf
            <div class="relative flex flex-col items-center bg-white shadow-lg rounded-lg p-4 w-full max-w-xs md:max-w-md lg:max-w-lg mx-auto"
                id="content">
                <div class="w-full p-4">
                    <div class="space-y-4">


                        {{-- FORM GANTI FOTO --}}
                        <div class="flex flex-col items-center">
                            @if (!empty(Auth::guard('karyawan')->user()->foto))
                                @php
                                    $path = Storage::url(
                                        'uploads/karyawan/fotoProfile/' . Auth::guard('karyawan')->user()->foto,
                                    );
                                @endphp
                                <img alt="Profile picture of Adhy Wira Pratama"
                                    class="object-cover h-32 w-32 rounded-full mb-2 border-4 border-white shadow-md"
                                    height="100" src="{{ url($path) }}" width="100" />
                            @else
                                <img alt="Profile picture of Adhy Wira Pratama"
                                    class="object-cover h-48 w-full rounded-full mb-2 border-4 border-white shadow-md"
                                    height="100" src="{{ asset('assets/img/default-profile.jpg') }}" width="100" />
                            @endif
                            <input
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                id="foto" name="foto" type="file" />
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ $karyawan->nama }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">NRP</label>
                            <input type="text" name="department" id="department"
                                value="{{ Auth::guard('karyawan')->user()->nrp }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                readonly>
                        </div>
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="number" name="telp" id="telp" value="{{ $karyawan->telp }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" name="department" id="department"
                                value="{{ Auth::guard('karyawan')->user()->department }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                readonly>
                        </div>
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan"
                                value="{{ Auth::guard('karyawan')->user()->jabatan }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                readonly>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" onclick="confirmUpdate()"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">Update
                                Profile</button>
                        </div>
                    </div>
                </div>
        </form>
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
        function confirmUpdate() {
            Swal.fire({
                title: 'Apakah data yang di edit sudah benar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profileForm').submit();
                }
            })
        }
    </script>
@endsection
