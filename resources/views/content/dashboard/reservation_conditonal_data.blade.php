@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pengguna')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables-responsive.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/editor.css" />
@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/katex.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/quill.js">
    </script>
@endsection

@section('page-script')
    <script>
        const quill = new Quill("#snow-editor", {
            bounds: "#snow-editor",
            modules: {
                formula: !0,
                toolbar: "#snow-toolbar"
            },
            theme: "snow"
        });

        $('.setuju').on('click', function(e) {
            e.preventDefault();

            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda setuju?',
                text: "Anda tidak bisa mengembalikan aksi anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin, setuju!',
                customClass: {
                    confirmButton: 'btn btn-primary me-1',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });

        $('.tidak-setuju').on('click', function(e) {
            e.preventDefault();

            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda tidak setuju?',
                text: "Anda tidak bisa mengembalikan aksi anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin, tidak setuju!',
                customClass: {
                    confirmButton: 'btn btn-primary me-1',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });


        var dt_basic_table = $('.datatables-basic');
        var dt_basic = dt_basic_table.DataTable({
            responsive: true,
            language: {
                "sEmptyTable": "Tidak ada data yang tersedia",
                "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari total _MAX_ entri)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sLoadingRecords": "Memuat...",
                "sProcessing": "Memproses...",
                "sSearch": "Cari:",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sLast": "Terakhir",
                    "sNext": "Selanjutnya",
                    "sPrevious": "Sebelumnya"
                },
                "oAria": {
                    "sSortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                    "sSortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
                },
                "sSortAscending": " (aktifkan untuk mengurutkan kolom secara ascending)",
                "sSortDescending": " (aktifkan untuk mengurutkan kolom secara descending)"
            }
        });

        $(document).ready(function() {
            var toast = $('#toast');
            toast.toast('show'); // Menampilkan toast

            // Menutup toast secara otomatis setelah 5 detik (5000 ms)
            setTimeout(function() {
                toast.toast('hide');
            }, 2500);
        });

        // Fungsi untuk menampilkan modal dengan data dari tombol Add yang diklik
        function showModal(reservation_id, room_id) {
            $("#reservation_id").val(reservation_id);
            $("#room_id").val(room_id);
            $("#deleteModal").modal("show");
        }

        // Event listener untuk tombol Add
        $(document).on("click", "#delete-btn", function() {
            const reservation_id = $(this).data("reservation_id");
            const room_id = $(this).data("room_id");
            showModal(reservation_id, room_id);
        });

        // Menangani pengiriman formulir
        var form = document.querySelector('#formModal');
        form.onsubmit = function(event) {
            // Mendapatkan nilai teks dari editor dan memasukkan ke input tersembunyi
            var quillContent = quill.root.innerHTML;
            document.getElementById('quill-content').value = quillContent;
        };
    </script>
@endsection

@section('content')

    @if (session()->has('message'))
        <div id="toast" class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Berhasil!</div>
                <small>Baru saja</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- DataTable with Buttons -->
    <div class="row g-4 mb-4">
        @if (!auth()->user()->signature)
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert">
                    <span class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
                            class="bx bx-error fs-6"></i></span>
                    <span>Kami meminta Anda untuk menambahkan tanda tangan Anda ke profil. Tanda tangan ini akan digunakan
                        untuk keperluan administrasi. <a href="/settings" class="fw-bold">Klik disini</a></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            </div>
        @endif
    
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih Gedung
                          </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($buildings as $building)
                                <li><a class="dropdown-item" href="/reservation_conditional/{{ $building->id }}">{{ $building->building_name }}</a></li>
                            @endforeach
                            
                        </ul>
                        @if ($id!=NULL)
                        <div class="alert alert-primary" role="alert">
                            {{ $buildingx->building_name }}
                          </div>
                        @endif
                    </div>
                    {{-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bx bx-plus"></i> Tambah Ruangan</button> --}}
                    {{-- <hr> --}}
                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table border-top" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Pemohon</th>
                                    <th>Termohon</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Keperluan</th>
                                    {{-- <th>Jaminan</th> --}}
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-3">
                                                        <img src="{{ asset($reservation->user->avatar) }}"
                                                            alt="{{ $reservation->user->fullname }}" class="rounded-circle"
                                                            style="object-fit: cover">
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="/profile/{{ $reservation->user->slug }}"
                                                        class="text-body text-truncate">
                                                        <span
                                                            class="fw-semibold">{{ $reservation->pemohon_name }}</span></a>
                                                    <small class="text-muted">{{ $reservation->pemohon_nim }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar avatar-sm me-3">
                                                        <img src="{{ asset($reservation->user->avatar) }}"
                                                            alt="{{ $reservation->user->fullname }}" class="rounded-circle"
                                                            style="object-fit: cover">
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="/profile/{{ $reservation->user->slug }}"
                                                        class="text-body text-truncate">
                                                        <span
                                                            class="fw-semibold">{{ $reservation->termohon_name }}</span></a>
                                                    <small class="text-muted">{{ $reservation->termohon_nim }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $reservation->room->name }}
                                            <small
                                                class="text-muted d-block">({{ strtoupper($reservation->room->ownership) }})</small>
                                        </td>
                                        <td>{{ $reservation->reservation_date }}</td>
                                        <td>{{ substr($reservation->session->start, 0, 5) }}</td>
                                        <td>{{ substr($reservation->end_time, 0, 5) }}</td>
                                        <td>
                                            @if (strlen($reservation->necessary) > 35)
                                                {{ substr($reservation->necessary, 0, 35) . '...' }}
                                            @else
                                                {{ $reservation->necessary }}
                                            @endif
                                        </td>
                                        {{-- <td>{{ strtoupper($reservation->guarantee) }}</td> --}}
                                        <td>
                                            @if ($reservation->room->ownership == 'baak')
                                                @if ($reservation->status_conditional == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($reservation->status_conditional == 'not approved')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($reservation->status_conditional == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif ($reservation->status_conditional == 'wait')
                                                    <span class="badge bg-success">Menunggu Dikembalikan</span>
                                                @elseif ($reservation->status_conditional == 'returned')
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                @elseif ($reservation->status_conditional == 'reschedule')
                                                    <span class="badge bg-warning">Jadwal Ulang</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            @else
                                                @if ($reservation->status_conditional == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($reservation->status_conditional == 'not approved')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($reservation->status_conditional == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif ($reservation->status_conditional == 'wait')
                                                    <span class="badge bg-success">Menunggu Dikembalikan</span>
                                                @elseif ($reservation->status_conditional == 'returned')
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                @elseif ($reservation->status_conditional == 'reschedule')
                                                    <span class="badge bg-warning">Jadwal Ulang</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        
                                        <td>
                                            
                                            @if ($reservation->status_conditional == 'wait')
                                                @if (auth()->user()->signature)
                                                    <a href="/returned/{{ $reservation->id }}"
                                                        class="btn btn-sm btn-primary setuju"><i class='bx bx-check'></i>
                                                        Acc Pengembalian</a>
                                                @endif
                                            @elseif ($reservation->status_conditional == 'pending')
                                                @if (auth()->user()->signature)
                                                    <div class="d-flex gap-2">
                                                        <a href="/approve_conditional/{{ $reservation->id_rr }}"
                                                            class="btn btn-sm btn-primary setuju"><i
                                                                class='bx bx-check'></i> Setuju</a>
                                                        <button id="delete-btn"
                                                            data-reservation_id="{{ $reservation->id_rr }}"
                                                            data-room_id="{{ $reservation->room->id }}"
                                                            class="btn btn-sm btn-danger"><i class='bx bx-x'></i> Tidak
                                                            Setuju</button>
                                                    </div>
                                                @else
                                                    <a href="/settings" class="btn btn-sm btn-primary">Lengkapi TTD untuk
                                                        melanjutkan</a>
                                                @endif
                                                {{-- @if ($reservation->conditional == 1)
                                                <a href="https://api.whatsapp.com/send?phone={{ $reservation->user->phone_number }}&text=Saya%20melihat%20promo%2075%%di%20website."
                                                    class="btn btn-sm btn-warning setuju"><i class='bx bx-check'></i>
                                                    Kirim Permohonan Kepada WA Termohon</a>
                                                @endif --}}
                                            @else
                                                -
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ DataTable with Buttons -->

    <!-- Modal -->
    <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan</h5>
                </div>
                <div class="modal-body">
                    <form action="/not_approve_conditional" method="POST" id="formModal">
                        @csrf
                        <input type="hidden" name="reservation_id" id="reservation_id">
                        <input type="hidden" name="room_id" id="room_id">
                        <div id="snow-toolbar">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                        </div>
                        <div id="snow-editor">
                        </div>
                        <!-- Input tersembunyi untuk menyimpan konten editor -->
                        <input type="hidden" name="note_admin" id="quill-content">
                        <small class="text-primary">*Kosongkan jika tidak ada catatan.</small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
