@extends('layouts.layoutNoFooter')
@section('header')
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
            <p>Maaf, Anda Tidak Memiliki Jadwal Shift Pada Hari Ini !, Silahkan Hubungi HC atau IT</p>
        </div>
    @endsection
