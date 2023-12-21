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
  
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-datatable table-responsive">
                        <table class="datatables-basic table border-top" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Keperluan</th>
                                    {{-- <th>Jaminan</th> --}}
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no=1;
                                @endphp
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $reservation->room->name }}</td>
                                        <td>
                                                {{ $reservation->reservation_date }}
                                        </td>
                                        <td>{{ substr($reservation->session->start, 0, 5) }}</td>
                                        <td>{{ substr($reservation->end_time, 0, 5) }}</td>
                                        <td>{{ $reservation->necessary }}</td>
                                        {{-- <td>{{ strtoupper($reservation->guarantee) }}</td> --}}
                                        <td>
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
