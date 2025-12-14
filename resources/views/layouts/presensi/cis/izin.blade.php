@extends('layouts.navCustom')
@section('content')
    <html lang="en">

    <head>
        <style>
            /* Animate menu items sliding up and fading in */
            #floating-menu.show>div {
                transform: translateY(0);
                opacity: 1;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #floating-menu>div {
                transform: translateY(20px);
                opacity: 0;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Stagger delay for each menu item */
            #floating-menu.show>div:nth-child(1) {
                transition-delay: 0.05s;
            }

            #floating-menu.show>div:nth-child(2) {
                transition-delay: 0.1s;
            }

            #floating-menu.show>div:nth-child(3) {
                transition-delay: 0.15s;
            }

            /* Rotate main button smoothly */
            #floating-btn.rotate-45 {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                transform: rotate(45deg);
            }

            #floating-btn {
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Blur overlay */
            #blur-overlay {
                position: fixed;
                inset: 0;
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                background-color: rgba(255, 255, 255, 0.2);
                z-index: 40;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            #blur-overlay.active {
                opacity: 1;
                pointer-events: auto;
            }

            /* Modal slide up animation */
            #detail-modal {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top-left-radius: 1rem;
                border-top-right-radius: 1rem;
                box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
                transform: translateY(100%);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
                z-index: 50;
                max-width: 480px;
                margin: 0 auto;
                width: 100%;
                padding: 1.5rem 1.5rem 2rem;
                display: none;
            }

            #detail-modal.show {
                transform: translateY(0);
                opacity: 1;
                display: block;
            }

            #detail-modal header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
            }

            #detail-modal header h2 {
                font-weight: 600;
                font-size: 1.25rem;
                color: #1f2937;
            }

            #detail-modal header button.close-btn {
                background: transparent;
                border: none;
                font-size: 1.5rem;
                color: #6b7280;
                cursor: pointer;
                transition: color 0.2s ease;
            }

            #detail-modal header button.close-btn:hover {
                color: #374151;
            }

            /* UPDATED: Added detail-row styles for modal details */
            #detail-modal .detail-row {
                margin-bottom: 0.5rem;
                color: #374151;
                font-weight: 500;
            }

            #detail-modal .detail-label {
                font-weight: 600;
                color: #1f2937;
            }

            /* UPDATED: Added styles for action buttons */
            #detail-modal .actions {
                display: flex;
                justify-content: space-between;
                margin-top: 1.5rem;
                gap: 0.75rem;
            }

            #detail-modal .actions button {
                flex: 1;
                padding: 0.75rem 0;
                border-radius: 0.375rem;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.2s ease;
                border: none;
                color: white;
            }

            #detail-modal .actions button.edit {
                background-color: #3b82f6;
                /* blue-500 */
            }

            #detail-modal .actions button.edit:hover {
                background-color: #2563eb;
                /* blue-600 */
            }

            #detail-modal .actions button.delete {
                background-color: #ef4444;
                /* red-500 */
            }

            #detail-modal .actions button.delete:hover {
                background-color: #dc2626;
                /* red-600 */
            }

            #detail-modal .actions button.close {
                background-color: #6b7280;
                /* gray-500 */
            }

            #detail-modal .actions button.close:hover {
                background-color: #4b5563;
                /* gray-600 */
            }

            /* Scroll lock when modal open */
            body.modal-open {
                overflow: hidden;
            }

            /* Make izin cards focusable and pointer cursor */
            .izin-card {
                cursor: pointer;
            }

            /* === START: iPhone style delete confirmation modal styles === */
            /* iPhone style modal blur background */
            #deleteConfirm::before {
                content: "";
                position: fixed;
                inset: 0;
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                z-index: -1;
            }

            /* iPhone style modal container */
            #deleteConfirm {
                position: fixed;
                inset: 0;
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 60;
            }

            #deleteConfirm.show {
                display: flex;
            }

            #deleteConfirm .modal-content {
                background: white;
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                max-width: 400px;
                width: 90%;
                border: 1px solid #d1d5db;
                /* gray-300 */
                overflow: hidden;
            }

            #deleteConfirm .modal-header {
                padding: 1.5rem 1.5rem 0.5rem 1.5rem;
                text-align: center;
            }

            #deleteConfirm .modal-header h5 {
                font-size: 1.25rem;
                font-weight: 600;
                color: #111827;
                /* gray-900 */
            }

            #deleteConfirm .modal-body {
                padding: 0.5rem 1.5rem 1.5rem 1.5rem;
                text-align: center;
                color: #4b5563;
                /* gray-700 */
                font-size: 1rem;
                line-height: 1.5rem;
            }

            #deleteConfirm .modal-footer {
                padding: 1rem 1.5rem 1.5rem 1.5rem;
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            #deleteConfirm .btn-inline {
                display: flex;
                gap: 1rem;
                width: 100%;
            }

            #deleteConfirm .btn {
                flex: 1;
                padding: 0.75rem 0;
                border-radius: 1rem;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                border: none;
                text-align: center;
                transition: background-color 0.2s ease;
                user-select: none;
            }

            #deleteConfirm .btn-text-secondary {
                background-color: white;
                border: 1.5px solid #9ca3af;
                /* gray-400 */
                color: #6b7280;
                /* gray-600 */
            }

            #deleteConfirm .btn-text-secondary:hover {
                background-color: #f3f4f6;
                /* gray-100 */
                border-color: #6b7280;
                /* gray-600 */
                color: #374151;
                /* gray-700 */
            }

            #deleteConfirm .btn-text-primary {
                background-color: #ef4444;
                /* red-600 */
                color: white;
            }

            #deleteConfirm .btn-text-primary:hover {
                background-color: #dc2626;
                /* red-700 */
            }
        </style>
    </head>

    <body class="relative min-h-screen rounded-lg bg-gradient-to-r from-blue-400/10 via-purple-500/10 to-pink-500/10"
        id="main-content">
    @section('judulHalaman')
        <a href="/">
            <button aria-label="Kembali ke menu sebelumnya"
                class="flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                onclick="window.history.back()">
                <i class="fas fa-arrow-left text-lg"></i>
            </button>
        </a>
        <h1 class="text-lg font-semibold truncate">
            Halaman Izin
        </h1>
    @endsection
    <div class="mt-70">
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

    <div class="m-1 p-2 ">
        <div class="container mx-auto max-w-md sm:max-w-lg md:max-w-3xl px-2">
            <div class="w-full space-y-4" id="izin-list">
                <!-- Cards will be rendered here by JS -->
            </div>
            <!-- Pagination Controls -->
            <div class="flex justify-center mt-6 space-x-2" id="pagination-controls" aria-label="Pagination">
                <!-- Buttons will be generated by JS -->
            </div>
        </div>
    </div>
    <!-- Blur Overlay -->
    <div id="blur-overlay" tabindex="-1" aria-hidden="true"></div>

    <!-- Floating Button Container -->
    <div class="fixed bottom-6 right-6 flex flex-col items-center space-y-4 z-50">
        <!-- Menu Buttons with Labels (hidden by default) -->
        <div class="flex flex-col space-y-4 mb-2 pointer-events-none" id="floating-menu" aria-label="Floating menu ">
            <div class="flex items-center space-x-2">
                <a href="/presensi/cis/buatIzin" aria-label="Izin"
                    class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    role="button" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-exclamation">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.348 0 .686 .045 1.008 .128" />
                        <path d="M19 16v3" />
                        <path d="M19 22v.01" />
                    </svg>
                </a>
                <span class="text-gray-700 font-bold text-sm select-none">Buat Izin</span>
            </div>
            <div class="flex items-center space-x-2">
                <a href="/presensi/cis/cuti" aria-label="Cuti"
                    class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    role="button" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-off">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552" />
                        <path
                            d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2" />
                        <path d="M3 3l18 18" />
                    </svg>
                </a>
                <span class="text-gray-700 font-medium text-sm select-none">Buat Cuti</span>
            </div>
            <div class="flex items-center space-x-2">
                <a href="/presensi/cis/izinSakit" aria-label="IzinSakit"
                    class="w-12 h-12 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    role="button" tabindex="0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-heart">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h.5" />
                        <path
                            d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z" />
                    </svg>
                </a>
                <span class="text-gray-700 font-medium text-sm select-none">Buat Izin Sakit</span>
            </div>
        </div>
        <!-- Main Floating Button -->
        <button aria-label="Toggle menu"
            class="w-14 h-14 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            id="floating-btn" type="button">
            <i class="fas fa-plus text-2xl" id="floating-btn-icon"></i>
        </button>
    </div>

    <!-- Modal -->
    <div id="detail-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title" class="max-w-md mx-auto">
        <header>
            <h2 id="modal-title">Aksi</h2>
            <button type="button" class="close-btn" aria-label="Close modal">&times;</button>
        </header>
        <div class="content" id="showact">

        </div>
    </div>

    <!-- === START: iPhone style delete confirmation modal === -->
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
    <!-- === END: iPhone style delete confirmation modal === -->

</body>
@endsection
@push('myscript')
<script>
    $(function() {
        const $floatingBtn = $('#floating-btn');
        const $floatingMenu = $('#floating-menu');
        const $floatingBtnIcon = $('#floating-btn-icon');
        const $blurOverlay = $('#blur-overlay');
        const $mainContent = $('#main-content');
        const $izinList = $('#izin-list');
        const $modal = $('#detail-modal');
        const $modalCloseBtn = $modal.find('button.close-btn');
        const $deleteConfirm = $('#deleteConfirm');
        const $cancelDeleteBtn = $('#cancelDeleteBtn');
        const $hapusPengajuanBtn = $('#hapuspengajuan');
        const $paginationControls = $('#pagination-controls');

        let menuOpen = false;
        let modalOpen = false;
        let deleteConfirmOpen = false;

        // Parse data_izin from blade into JS array
        const izinData = [];
        @foreach ($data_izin as $d)
            izinData.push({
                kode_izin: "{{ $d->kode_izin }}",
                status: "{{ $d->status }}",
                status_approved: {{ $d->status_approved }},
                tgl_izin_dari: "{{ date('d-m-Y', strtotime($d->tgl_izin_dari)) }}",
                tgl_izin_sampai: "{{ date('d-m-Y', strtotime($d->tgl_izin_sampai)) }}",
                keterangan: {!! json_encode($d->keterangan) !!},
                nama_cuti: {!! json_encode($d->nama_cuti ?? '') !!},
                doc_cis: {!! !empty($d->doc_cis) ? 'true' : 'false' !!}
            });
        @endforeach

        // Sort descending by tgl_izin_dari (newest first)
        izinData.sort((a, b) => {
            const dateA = a.tgl_izin_dari.split('-').reverse().join('-');
            const dateB = b.tgl_izin_dari.split('-').reverse().join('-');
            return dateB.localeCompare(dateA);
        });

        const itemsPerPage = 4;
        let currentPage = 1;
        const totalPages = Math.ceil(izinData.length / itemsPerPage);

        function hitungHari(tglDari, tglSampai) {
            const partsDari = tglDari.split('-');
            const partsSampai = tglSampai.split('-');
            const dari = new Date(partsDari[2], partsDari[1] - 1, partsDari[0]);
            const sampai = new Date(partsSampai[2], partsSampai[1] - 1, partsSampai[0]);
            const diffTime = sampai - dari;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays;
        }

        function statusLabel(status, approved) {
            if (approved === 0) {
                return `<span class="inline-block px-3 py-1 text-yellow-800 bg-yellow-200 rounded-full text-sm font-semibold whitespace-nowrap">Waiting</span>`;
            } else if (approved === 1) {
                return `<span class="inline-block px-3 py-1 text-green-800 bg-green-200 rounded-full text-sm font-semibold whitespace-nowrap">Approved</span>`;
            } else if (approved === 2) {
                return `<span class="inline-block px-3 py-1 text-red-800 bg-red-200 rounded-full text-sm font-semibold whitespace-nowrap">Decline</span>`;
            }
            return '';
        }

        function statusText(status) {
            if (status === 'i') return 'Izin';
            if (status === 's') return 'Sakit';
            if (status === 'c') return 'Cuti';
            return 'Not Found';
        }

        // UPDATED: Function to get edit button HTML based on status
        function getEditButtonHtml(status, kode_izin) {
            if (status === 'i') {
                return `<button type="button" class="edit bg-blue-600 hover:bg-blue-700 rounded-md px-4 py-2 text-white font-semibold" aria-label="Edit Izin"><a href="/presensi/izinCis/${kode_izin}/edit" class="block w-full h-full">Edit</a></button>`;
            } else if (status === 'c') {
                return `<button type="button" class="edit bg-blue-600 hover:bg-blue-700 rounded-md px-4 py-2 text-white font-semibold" aria-label="Edit Cuti"><a href="/presensi/izinCuti/${kode_izin}/edit" class="block w-full h-full">Edit</a></button>`;
            } else if (status === 's') {
                return `<button type="button" class="edit bg-blue-600 hover:bg-blue-700 rounded-md px-4 py-2 text-white font-semibold" aria-label="Edit Izin Sakit"><a href="/presensi/izinSakit/${kode_izin}/edit" class="block w-full h-full">Edit Sakit</a></button>`;
            }
            return '';
        }

        function renderPage(page) {
            $izinList.empty();
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageItems = izinData.slice(start, end);

            pageItems.forEach(d => {
                const hari = hitungHari(d.tgl_izin_dari, d.tgl_izin_sampai);
                const approved = d.status_approved;
                const canEditDelete = approved !== 1; // cannot edit/delete if approved
                let lampiranHtml = '';
                if (d.doc_cis) {
                    lampiranHtml = `<span style="color:#0000FF;">
                        <i class="fas fa-file-alt"></i> Lihat Lampiran
                    </span>`;
                }
                let namaCutiHtml = '';
                if (d.status === 'c' && d.nama_cuti) {
                    namaCutiHtml = `<br><span style="color: #cee617">${d.nama_cuti}</span>`;
                }
                const cardHtml = `
                <div tabindex="0" class="izin-card border border-gray-300 rounded-md p-4 bg-white shadow-sm flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    kode_izin="${d.kode_izin}" data-status="${d.status}" data-status-approved="${approved}"
                    data-tgl-dari="${d.tgl_izin_dari}" data-tgl-sampai="${d.tgl_izin_sampai}"
                    data-keterangan="${d.keterangan}" data-nama-cuti="${d.nama_cuti}" data-doc-cis="${d.doc_cis}">
                    <div>
                        <b class="text-gray-900 text-base sm:text-lg block">
                            ${d.tgl_izin_dari} (${statusText(d.status)})
                        </b>
                        <small class="text-gray-800 block mt-1">${d.tgl_izin_dari} s/d ${d.tgl_izin_sampai} (${hari} hari)</small>
                        <p class="text-gray-700 block mt-1">
                            ${d.keterangan}${namaCutiHtml}
                            ${lampiranHtml}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        ${statusLabel(d.status, approved)}
                    </div>
                    ${canEditDelete ? `<button type="button"
                        class="delete-button ml-4 px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
                        aria-label="Hapus pengajuan izin ${d.kode_izin}"
                        data-kode-izin="${d.kode_izin}">
                        <i class="fas fa-trash-alt"></i>
                    </button>` : ''}
                </div>`;
                $izinList.append(cardHtml);
            });

            renderPagination();
            attachCardEvents();
        }

        function renderPagination() {
            $paginationControls.empty();

            // Previous button
            const prevDisabled = currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-100';
            $paginationControls.append(`
                <button aria-label="Previous page" id="prevPage" class="px-3 py-1 rounded-md ${prevDisabled} focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `);

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'bg-indigo-600 text-white' :
                    'bg-white text-gray-700 hover:bg-indigo-100';
                $paginationControls.append(`
                    <button aria-label="Page ${i}" data-page="${i}" class="px-3 py-1 rounded-md ${activeClass} focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        ${i}
                    </button>
                `);
            }

            // Next button
            const nextDisabled = currentPage === totalPages ? 'opacity-50 cursor-not-allowed' :
                'hover:bg-indigo-100';
            $paginationControls.append(`
                <button aria-label="Next page" id="nextPage" class="px-3 py-1 rounded-md ${nextDisabled} focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `);

            // Pagination button events
            $('#prevPage').off('click').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });
            $('#nextPage').off('click').on('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });
            $paginationControls.find('button[data-page]').off('click').on('click', function() {
                const page = parseInt($(this).data('page'));
                if (page !== currentPage) {
                    currentPage = page;
                    renderPage(currentPage);
                }
            });
        }

        function attachCardEvents() {
            const $izinCards = $('.izin-card');
            $izinCards.off('click keydown').on('click keydown', function(e) {
                var kode_izin = $(this).attr("kode_izin");
                if (e.type === 'click' || (e.type === 'keydown' && (e.key === 'Enter' || e.key ===
                        ' '))) {
                    e.preventDefault();
                    openModal();
                    const statusApproved = $(this).data('status-approved');
                    const status = $(this).data('status');
                    const tglDari = $(this).data('tgl-dari');
                    const tglSampai = $(this).data('tgl-sampai');
                    const keterangan = $(this).data('keterangan');
                    const namaCuti = $(this).data('nama-cuti');
                    const docCis = $(this).data('doc-cis') === true || $(this).data('doc-cis') ===
                        'true';

                    let contentHtml =
                        `<div class="detail-row"><span class="detail-label">Kode Izin:</span> ${kode_izin}</div>`;
                    contentHtml +=
                        `<div class="detail-row"><span class="detail-label">Status:</span> ${statusText(status)}</div>`;
                    contentHtml +=
                        `<div class="detail-row"><span class="detail-label">Tanggal:</span> ${tglDari} s/d ${tglSampai}</div>`;
                    contentHtml +=
                        `<div class="detail-row"><span class="detail-label">Keterangan:</span> ${keterangan}</div>`;
                    if (status === 'c' && namaCuti) {
                        contentHtml +=
                            `<div class="detail-row"><span class="detail-label">Nama Cuti:</span> ${namaCuti}</div>`;
                    }
                    if (docCis) {
                        contentHtml +=
                            `<div class="detail-row"><a href="#" class="text-blue-600 underline">Lihat Lampiran</a></div>`;
                    }

                    if (statusApproved === 1) {
                        contentHtml +=
                            `<div class="mt-4 text-green-700 font-semibold">Pengajuan sudah di-approve dan tidak dapat diubah atau dihapus.</div>`;
                        contentHtml += `<div class="actions mt-6 flex gap-4">
                            <button type="button" class="close bg-gray-600 hover:bg-gray-700 rounded-md px-4 py-2 text-white font-semibold" id="close-btn">Tutup</button>
                        </div>`;
                    } else {
                        contentHtml += `<div class="actions mt-6 flex gap-4">`;
                        // UPDATED: Use conditional edit button with correct link
                        contentHtml += getEditButtonHtml(status, kode_izin);
                        contentHtml +=
                            `<button type="button" class="delete bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-white font-semibold" id="delete-btn">Hapus</button>`;
                        contentHtml +=
                            `<button type="button" class="close bg-gray-600 hover:bg-gray-700 rounded-md px-4 py-2 text-white font-semibold" id="close-btn">Tutup</button>`;
                        contentHtml += `</div>`;
                    }

                    $("#showact").html(contentHtml);

                    $('#close-btn').on('click', function() {
                        closeModal();
                    });

                    $('#delete-btn').on('click', function() {
                        closeModal();
                        openDeleteConfirm('/presensi/cis/' + kode_izin + '/delete');
                    });
                }
            });

            // Delete button on card
            $('.delete-button').off('click').on('click', function(e) {
                e.preventDefault();
                const kodeIzin = $(this).data('kode-izin');
                if (!kodeIzin) return;
                const $card = $(`.izin-card[kode_izin="${kodeIzin}"]`);
                const statusApproved = $card.data('status-approved');
                if (statusApproved === 1) {
                    alert('Pengajuan yang sudah di-approve tidak dapat dihapus.');
                    return;
                }
                const deleteUrl = '/presensi/cis/' + kodeIzin + '/delete';
                openDeleteConfirm(deleteUrl);
            });
        }

        function openMenu() {
            $floatingMenu.addClass('show').css('pointer-events', 'auto');
            $floatingBtnIcon.removeClass('fa-plus').addClass('fa-times');
            $floatingBtn.addClass('rotate-45');
            $blurOverlay.addClass('active');
            $mainContent.attr('aria-hidden', 'true');
            $floatingBtn.attr('aria-expanded', 'true');
        }

        function closeMenu() {
            $floatingMenu.removeClass('show').css('pointer-events', 'none');
            $floatingBtnIcon.removeClass('fa-times').addClass('fa-plus');
            $floatingBtn.removeClass('rotate-45');
            $blurOverlay.removeClass('active');
            $mainContent.removeAttr('aria-hidden');
            $floatingBtn.attr('aria-expanded', 'false');
        }

        $floatingBtn.on('click', function() {
            menuOpen = !menuOpen;
            if (menuOpen) {
                openMenu();
            } else {
                closeMenu();
            }
        });

        $blurOverlay.on('click', function() {
            if (menuOpen) {
                menuOpen = false;
                closeMenu();
            }
            if (modalOpen) {
                closeModal();
            }
            if (deleteConfirmOpen) {
                closeDeleteConfirm();
            }
        });

        function openModal() {
            $modal.show();
            setTimeout(() => {
                $modal.addClass('show');
            }, 10);
            $blurOverlay.addClass('active');
            $('body').addClass('modal-open');
            modalOpen = true;
            $mainContent.attr('aria-hidden', 'true');
        }

        function closeModal() {
            $modal.removeClass('show');
            $blurOverlay.removeClass('active');
            $('body').removeClass('modal-open');
            modalOpen = false;
            $mainContent.removeAttr('aria-hidden');
            setTimeout(() => {
                $modal.hide();
            }, 300);
        }

        // Delete confirmation modal logic
        function openDeleteConfirm(hapusUrl) {
            $hapusPengajuanBtn.attr('href', hapusUrl);
            $deleteConfirm.addClass('show');
            $blurOverlay.addClass('active');
            $('body').addClass('modal-open');
            deleteConfirmOpen = true;
            $mainContent.attr('aria-hidden', 'true');
        }

        function closeDeleteConfirm() {
            $deleteConfirm.removeClass('show');
            $blurOverlay.removeClass('active');
            $('body').removeClass('modal-open');
            deleteConfirmOpen = false;
            $mainContent.removeAttr('aria-hidden');
        }

        $cancelDeleteBtn.on('click', function(e) {
            e.preventDefault();
            closeDeleteConfirm();
        });

        // Initialize first page
        renderPage(currentPage);
    });
</script>
@endpush
