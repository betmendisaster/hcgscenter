<div class="detail-row">
    <span class="detail-label">Kode Izin:</span>
    <span class="detail-value" id="detail-kode-izin">{{ $dataIzin->kode_izin }}</span>
</div>
<div class="detail-row">
    <span class="detail-label">Tanggal Mulai:</span>
    <span class="detail-value" id="detail-tgl-dari">{{ date('d-m-Y', strtotime($dataIzin->tgl_izin_dari)) }}</span>
</div>
<div class="detail-row">
    <span class="detail-label">Tanggal Sampai:</span>
    <span class="detail-value" id="detail-tgl-sampai">{{ date('d-m-Y', strtotime($dataIzin->tgl_izin_sampai)) }}</span>
</div>
<div class="detail-row">
    <span class="detail-label">Jumlah Hari:</span>
    <span class="detail-value"
        id="detail-jumlah-hari">{{ hitungHari($dataIzin->tgl_izin_dari, $dataIzin->tgl_izin_sampai) }} hari</span>
</div>
<div class="detail-row">
    <span class="detail-label">Keterangan:</span>
    <span class="detail-value" id="detail-keterangan">{{ $dataIzin->keterangan }}</span>
</div>
{{-- <div class="detail-row" id="detail-nama-cuti-row" style="display:none;">
    <span class="detail-label">Nama Cuti:</span>
    <span class="detail-value" id="detail-nama-cuti">
        @if ($dataIzin->status == 'c')
            <span style="color: #cee617">{{ $dataIzin->nama_cuti }}</span>
        @endif
    </span>
</div> --}}
<div class="detail-row" id="detail-doc-cis-row" style="display:none;">
    <span class="detail-label">Lampiran:</span>
</div>
@if ($dataIzin->doc_cis != null)
    <div class="relative w-full max-w-sm mx-auto sm:mx-0">
        @php
            $doc_cis = Storage::url('/uploads/cis/' . $dataIzin->doc_cis);
        @endphp
        <img src="{{ url($doc_cis) }}" alt="" width="150px">
    </div>
@endif
<div class="detail-row">
    <span class="detail-label">Status Persetujuan:</span>
    <span class="detail-value" id="detail-status-approved">
        @if ($dataIzin->status_approved == 0)
            <span
                class="inline-block px-3 py-1 text-yellow-800 bg-yellow-200 rounded-full text-sm font-semibold whitespace-nowrap">Waiting</span>
            </button>
        @elseif($dataIzin->status_approved == 1)
            <span
                class="inline-block px-3 py-1 text-green-800 bg-green-200 rounded-full text-sm font-semibold whitespace-nowrap">Approved</span>
        @elseif($dataIzin->status_approved == 2)
            <span
                class="inline-block px-3 py-1 text-red-800 bg-red-200 rounded-full text-sm font-semibold whitespace-nowrap">Decline</span>
        @endif
    </span>
</div>
<div class="actions">
    @if ($dataIzin->status == 'i')
        <button type="button" class="edit" aria-label="Edit">
            <a href="/presensi/izinCis/{{ $dataIzin->kode_izin }}/edit">
                Edit</a></button>
    @elseif($dataIzin->status == 'c')
        <button type="button" class="edit" aria-label="Edit">
            <a href="/presensi/izinCuti/{{ $dataIzin->kode_izin }}/edit">
                Edit</a></button>
    @elseif($dataIzin->status == 's')
        <button type="button" class="edit" aria-label="Edit">
            <a href="/presensi/izinSakit/{{ $dataIzin->kode_izin }}/edit">
                Edit Sakit</a></button>
    @endif

    <div id="deleteConfirm" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title"
        aria-describedby="delete-modal-description" tabindex="-1" class="">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="delete-modal-title">Yakin Dihapus ?</h5>
            </div>
            <div class="modal-body" id="delete-modal-description">
                Data Pengajuan Izin Akan dihapus
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <button type="button" id="cancelDeleteBtn" class="btn btn-text-secondary">Batalkan</button>
                    <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="close" aria-label="Close modal">Close</button>
</div>
