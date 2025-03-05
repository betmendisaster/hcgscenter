<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Report Rekap Presensi Periode {{ $namaBulan[$bulan] }} {{ $tahun }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: ;
            font-weight: bold;
            font-size: 14px;
        }

        #alamat {
            font-family: ;
            font-size: 12px;
            font-style: italic;
        }

        .tableDataKaryawan {
            margin-top: 40px;
        }

        .tablePresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 10px;
            text-align: center
        }

        .tablePresensi tr th {
            border: 1px solid black;
            padding: 8px;
            background-color: #baafaf;
        }

        #td_tablePresensi {
            border: 1px solid black;
        }

        #tr_tablePresensi {
            border: 1px solid black;
        }

        #th_tablePresensi {
            border: 1px solid black;
            padding: 3px;
            font-size: 11px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    function selisih($jam_in, $jam_out)
    {
        [$h, $m, $s] = explode(':', $jam_in);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_out);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->
        {{-- <article>This is an A4 document.</article> --}}

        <table style="width: 100%;">
            <tr>
                <td>
                    <img src="{{ asset('assets/img/logo.png') }}" width="80" height="70" alt="">
                </td>
                <td>
                    <span id="title">
                        REPORT REKAP PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }} <br>
                        PT. HASNUR RIUNG SINERGI SITE AGM<br>
                    </span>
                    <span id="alamat">Jln. Office site AGM Block IV, Jl. A. Yani, Desa Tatakan, Kec.Tapin Selatan,
                        Kab.Tapin,
                        Kalimantan Selatan, Indonesia</span>
                </td>
            </tr>
        </table>
        <table class="tablePresensi">
            <tr>
                <th rowspan="2">NRP</th>
                <th rowspan="2">Nama</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">Total Hadir</th>
                <th rowspan="2">Total Telat</th>
            </tr>
            <tr id="tr_tablePresensi">
                <?php
                    for ($i = 1; $i <= 31; $i++){
                ?>
                <th id="th_tablePresensi"> {{ $i }} </th>
                <?php
                    }
                ?>
            </tr>
            @foreach ($rekap as $d)
                <tr id="tr_tablePresensi">
                    <td id="td_tablePresensi">{{ $d->nrp }}</td>
                    <td> {{ $d->nama }}</td>

                    <?php
                    $totHadir = 0;
                    $totLate = 0;
                    for ($i = 1; $i <= 31; $i++){
                        $tgl = "tgl_".$i;
                        if(empty($d->$tgl)){
                            $hadir = ['',''];
                            $totHadir += 0;
                        }else {
                            $hadir = explode("-",$d->$tgl);
                            $totHadir += 1;
                            if($hadir[0] > "07:00:00"){
                                $totLate +=1;
                            }
                        }
                    ?>

                    <td id="td_tablePresensi">
                        {{-- CEK TELAT NYA DISINI --}}
                        <span style="color: {{ $hadir[0] > '07:00:00' ? 'red' : '' }}">
                            {{ $hadir[0] }}</span><br>
                        <span style="color: {{ $hadir[1] < '17:55:00' ? 'red' : '' }}">
                            {{ $hadir[1] }}
                    </td>
                    <?php
                    }
                    ?>
                    <td id="td_tablePresensi">{{ $totHadir }} Hari</td>
                    <td id="td_tablePresensi">{{ $totLate }} Kali</td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px;">
            <tr>
                <td></td>
                <td style="text-align: center;">Tapin, {{ date('d-m-Y') }}</td>
            </tr>

            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>Farrel Hebat</u><br>
                    <i><b>HC Group Leader</b></i>
                </td>
                <td style="text-align: center; vertical-align: bottom;">
                    <u>Widodo Pranto</u><br>
                    <i><b>Dept. Head HCGS</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
