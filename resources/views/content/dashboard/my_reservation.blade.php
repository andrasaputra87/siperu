@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pengguna')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables-responsive.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
@endsection

@section('page-script')
    <script>
        $('.tombol-konfirmasi').on('click', function(e) {
            e.preventDefault();

            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak bisa mengembalikan aksi anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin, kembalikan!',
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

        $('.tombol-reschedule').on('click', function(e) {
            e.preventDefault();

            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin ingin merubah waktu dan tanggal?',
                text: "Anda tidak bisa mengembalikan aksi anda!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin!',
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
        function showModal(note) {
            $("#note-admin").html(note);
            $("#noteModal").modal("show");
        }

        $("#myTable").on("click", "#note-btn", function() {
            const note = $(this).data("note");
            showModal(note);
        });
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
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Peminjaman</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ count($reservations) }}</h4>
                            </div>
                            <small>Total Peminjaman</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class='bx bxs-calendar'></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Disetujui</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $reservations_approved }}</h4>
                                <small
                                    class="text-success">({{ count($reservations) > 0 ? round(($reservations_approved / count($reservations)) * 100) . '%' : '0%' }})</small>
                            </div>
                            <small>Peminjaman yang disetujui </small>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class='bx bxs-calendar-check'></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Tidak Disetujui</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $reservations_not_approved }}</h4>
                                <small
                                    class="text-danger">({{ count($reservations) > 0 ? round(($reservations_not_approved / count($reservations)) * 100) . '%' : '0%' }})</small>
                            </div>
                            <small>Peminjaman tidak disetujui </small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class='bx bxs-calendar-x'></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Dijadwal Ulang</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $reschedule }}</h4>
                                <small
                                    class="text-warning">({{ count($reservations) > 0 ? round(($reschedule / count($reservations)) * 100) . '%' : '0%' }})</small>
                            </div>
                            <small>Peminjaman dijadwal ulang </small>
                        </div>
                        <span class="badge bg-label-warning rounded p-2">
                            <i class='bx bxs-calendar-x'></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Dibatalkan</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $reservations_cancelled }}</h4>
                                <small
                                    class="text-danger">({{ count($reservations) > 0 ? round(($reservations_cancelled / count($reservations)) * 100) . '%' : '0%' }})</small>
                            </div>
                            <small>Peminjaman yang dibatalkan </small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class='bx bx-calendar-exclamation'></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="/history" class="btn btn-sm btn-primary"><i class="bx bx-history"></i> Lihat Riwayat</a>
                    <hr>
                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table border-top" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Sisa Waktu</th>
                                    <th>Keperluan</th>
                                    <th>Jaminan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $reservation->room->name }}</td>
                                        <td>{{ $reservation->reservation_date }}</td>
                                        <td>{{ substr($reservation->session->start, 0, 5) }}</td>
                                        <td>{{ substr($reservation->end_time, 0, 5) }}</td>
                                        <td> 
                                            @if (
                                                $reservation->status == 'approved' &&
                                                    \Illuminate\Support\Carbon::parse($reservation->reservation_date . ' ' . $reservation->session->start)->isPast())
                                                @if (!$reservation->key_status)
                                                    <div id="countdown-{{ $reservation->id }}"></div>
                                                @else
                                                    Waktu Habis
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $reservation->necessary }}</td>
                                        <td>{{ strtoupper($reservation->guarantee) }}</td>
                                        <td>
                                            @if ($reservation->room->ownership == 'baak')
                                                @if ($reservation->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($reservation->status == 'not approved')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif ($reservation->status == 'returned')
                                                    <span class="badge bg-success">DiKembalikan</span>
                                                @elseif ($reservation->status == 'reschedule')
                                                    <span class="badge bg-warning">Jadwal Ulang</span>
                                                @elseif ($reservation->status == 'wait')
                                                    <span class="badge bg-warning">Menunggu DiKembalikan</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            @else
                                                @if ($reservation->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($reservation->status == 'not approved')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @elseif ($reservation->status == 'returned')
                                                    <span class="badge bg-success">DiKembalikan</span>
                                                @elseif ($reservation->status == 'reschedule')
                                                    <span class="badge bg-warning">Jadwal Ulang</span>
                                                @elseif ($reservation->status == 'wait')
                                                    <span class="badge bg-warning">Menunggu DiKembalikan</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($reservation->room->ownership == 'baak')
                                                @if (
                                                    $reservation->status == 'approved' &&
                                                        \Illuminate\Support\Carbon::parse($reservation->reservation_date . ' ' . $reservation->session->start)->isPast())
                                                    @if (!$reservation->key_status)
                                                        <a href="/return/{{ $reservation->id }}/{{ $reservation->room_id }}"
                                                            class="btn btn-sm btn-primary tombol-konfirmasi"><i
                                                                class='bx bx-check'></i> Kembalikan</a>
                                                    @else
                                                        <span class="badge bg-success">Dikembalikan</span>
                                                    @endif
                                                @elseif ($reservation->status == 'approved')
                                                    <a href="/reschedule/{{ $reservation->id }}"
                                                        class="btn btn-sm btn-success tombol-reschedule"><i
                                                            class='bx bx-calendar'></i>Jadwal Ulang</a>
                                                @elseif ($reservation->status == 'reschedule')
                                                    <a href="/reschedule/{{ $reservation->id }}"
                                                        class="btn btn-sm btn-success tombol-reschedule"><i
                                                            class='bx bx-calendar'></i>Jadwal Ulang</a>
                                                @elseif($reservation->status == 'pending')
                                                    <a href="/cancel/{{ $reservation->id }}/{{ $reservation->room_id }}"
                                                        class="btn btn-sm btn-danger"><i class='bx bx-x'></i>
                                                        Batalkan</a>
                                                @elseif($reservation->status == 'not approved')
                                                    <button id="note-btn" data-note="{{ $reservation->note_admin }}"
                                                        class="btn btn-sm btn-primary"><i class='bx bx-show me-1'></i>
                                                        Lihat
                                                        Catatan</button>
                                                @else
                                                    -
                                                @endif
                                            @else
                                                @if (
                                                    $reservation->status == 'approved' &&
                                                        \Illuminate\Support\Carbon::parse($reservation->reservation_date . ' ' . $reservation->start_time)->isPast())
                                                    @if (!$reservation->key_status)
                                                        <a href="/return/{{ $reservation->id }}"
                                                            class="btn btn-sm btn-primary tombol-konfirmasi"><i
                                                                class='bx bx-check'></i> Kembalikan</a>
                                                    @else
                                                        <span class="badge bg-success">Dikembalikan</span>
                                                    @endif
                                                @elseif ($reservation->status == 'approved')
                                                    <a href="/reschedule/{{ $reservation->id }}"
                                                        class="btn btn-sm btn-success tombol-reschedule"><i
                                                            class='bx bx-calendar'></i>Jadwal Ulang</a>
                                                @elseif ($reservation->status == 'reschedule')
                                                    <a href="/reschedule/{{ $reservation->id }}"
                                                        class="btn btn-sm btn-success tombol-reschedule"><i
                                                            class='bx bx-calendar'></i>Jadwal Ulang</a>
                                                @elseif($reservation->status == 'pending')
                                                    <a href="/cancel/{{ $reservation->id }}/{{ $reservation->room_id }}"
                                                        class="btn btn-sm btn-danger"><i class='bx bx-x'></i>
                                                        Batalkan</a>
                                                @elseif($reservation->status == 'not approved')
                                                    <button id="note-btn" data-note="{{ $reservation->note_admin }}"
                                                        class="btn btn-sm btn-primary"><i class='bx bx-show me-1'></i>
                                                        Lihat
                                                        Catatan</button>
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($reservation->status == 'approved')
                                        <script>
                                            // Ambil waktu sekarang di sisi klien
                                            var currentTime{{ $reservation->id }} = new Date();

                                            // Ambil waktu target dari data reservasi
                                            var targetTime{{ $reservation->id }} = new Date();
                                            var timeParts{{ $reservation->id }} = "{{ $reservation->end_time }}".split(':');
                                            targetTime{{ $reservation->id }}.setHours(parseInt(timeParts{{ $reservation->id }}[0]));
                                            targetTime{{ $reservation->id }}.setMinutes(parseInt(timeParts{{ $reservation->id }}[1]));
                                            targetTime{{ $reservation->id }}.setSeconds(parseInt(timeParts{{ $reservation->id }}[2]));

                                            // Hitung selisih waktu antara waktu sekarang dan waktu target
                                            var timeDifference{{ $reservation->id }} = targetTime{{ $reservation->id }} - currentTime{{ $reservation->id }};

                                            // Perbarui hitung mundur setiap detik
                                            setInterval(function() {
                                                // Kurangi satu detik dari selisih waktu
                                                timeDifference{{ $reservation->id }} -= 1000;
                                                    
                                                // Jika waktu masih positif, lanjutkan perhitungan dan pembaruan
                                                if (timeDifference{{ $reservation->id }} > 0) {
                                                    // Hitung jam, menit, dan detik dari selisih waktu
                                                    var seconds{{ $reservation->id }} = Math.floor((timeDifference{{ $reservation->id }} / 1000) %
                                                        60); // detik
                                                    var minutes{{ $reservation->id }} = Math.floor((timeDifference{{ $reservation->id }} / 1000 /
                                                        60) % 60); // menit
                                                    var hours{{ $reservation->id }} = Math.floor((timeDifference{{ $reservation->id }} / (1000 * 60 *
                                                        60)) % 24); // jam

                                                    // Format waktu ke dalam string jam:menit:detik
                                                    var formattedTime{{ $reservation->id }} = hours{{ $reservation->id }} + ':' +
                                                        minutes{{ $reservation->id }} + ':' + seconds{{ $reservation->id }};
                                                    // Perbarui elemen HTML dengan ID yang sesuai
                                                    document.getElementById("countdown-{{ $reservation->id }}").innerHTML = formattedTime{{ $reservation->id }};
                                                } else {
                                                    // Jika waktu telah melewati waktu akhir, tampilkan 0:00:00
                                                    document.getElementById("countdown-{{ $reservation->id }}").innerHTML = 'Waktu Habis';
                                                }
                                            }, 1000);
                                        </script>
                                    @endif
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
    <div class="modal" id="noteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan</h5>
                </div>
                <div class="modal-body">
                    <div id="note-admin"></div>
                </div>
                <div class="modal-footer">
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
