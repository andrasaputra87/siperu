@extends('layouts/contentNavbarLayout')

@section('title', 'Pinjam Ruangan')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables-responsive.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.css" />
    <style>
        /* Styles for signature plugin v1.2.0. */
        .kbw-signature {
            width: 40%;
            height: 200px;
        }

        #sign canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://keith-wood.name/js/jquery.signature.js"></script>
@endsection

@section('page-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/js/forms-selects.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var toast = $('#toast');
            toast.toast('show'); // Menampilkan toast

            // Menutup toast secara otomatis setelah 5 detik (5000 ms)
            setTimeout(function() {
                toast.toast('hide');
            }, 2500);
        });

        var dt_basic_table = $('.datatables-basic');
        var dt_basic = dt_basic_table.DataTable({
            ordering: false,
            responsive: true,
            info: false,
            searching: false,
            lengthChange: false,
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


        var sign = $('#sign').signature({
            syncField: '#signature',
            syncFormat: 'PNG',
        });

        $('#clear').click(function(e) {
            e.preventDefault();
            sign.signature('clear');
            $('#signature').val('');
        });
    </script>
    <script>


        // Dapatkan elemen input tanggal
        const reservationDateInput = document.getElementById('reservation_date');

        // Dapatkan tanggal hari ini
        const today = new Date().toISOString().split('T')[0];

        // Atur nilai minimum tanggal untuk tanggal hari ini
        reservationDateInput.setAttribute('min', today);


        function myFunction() {
            let date = document.getElementById("reservation_date").value;
            let id_room = {{ $room->id }};
            // alert(date);
            $.ajax({
                type:'POST',
                url:'/get_conditional',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{date:date,id_room:id_room},
                success:function(html){
                    // console.log(html.data)
                    if (html.success) {
                        $("#start_time").empty();
                        $("#start_time").append('<option>Pilih Sesi</option>');
                        $.each(html.data, function (key, value) {

                            $("#start_time").append('<option value="' + value[
                                    "id"] + '">' + value["start"].substring(0,5) + ' WIB (' + value["nama"] +
                                ') </option>');
                        });
                    }else{
                        alert(html.data);
                    }
                }
            })
        }
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
        <div class="col-12 col-md-6 col-xl-7 col-xxl-8 mb-3">
            <div class="card">
                <div class="card-body">
                    @if (auth()->user()->role == 'user' &&
                            (!auth()->user()->nim || !auth()->user()->department_id || !auth()->user()->phone_number))
                        <div class="text-center mb-4">
                            <h4 class="address-title text-primary">Isi Data Diri Anda</h4>
                            <p>Oops! sepertinya anda belum melengkapi data diri anda. Isi form dibawah untuk melanjutkan
                                peminjaman.</p>
                        </div>
                        <hr>
                        <form action="/complete_personal_data/{{ auth()->user()->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim">NIM <span class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="nim"
                                        class="form-control @error('nim') invalid @enderror"
                                        value="{{ auth()->user()->nim ?? old('nim') }}">
                                    @error('nim')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number">No. Telepon <span class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="phone_number"
                                        class="form-control @error('phone_number') invalid @enderror"
                                        value="{{ auth()->user()->phone_number }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col mb-3">
                                    <label for="department_id">Jurusan <span class="text-danger fw-bold">*</span></label>
                                    <select name="department_id" id="select2Basic"
                                        class="select2 form-select @error('department_id') invalid @enderror"
                                        data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    @else
                        <div class="text-center mb-4">
                            <h4 class="address-title text-primary">{{ $room->name }}</h4>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Data Peminjaman</div>
                        </div>

                            <form action="{{ route('room_reservation_conditional.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="baak">
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="reservation_date">Tanggal Pinjam</label>
                                            <input type="date" id="reservation_date" name="reservation_date" onchange="myFunction()"
                                                class="form-control @error('reservation_date') border-danger @enderror"
                                                value="{{ old('reservation_date') }}" />
                                            @error('reservation_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-3 custom-col">
                                            <label class="form-label" for="start_time">Waktu Mulai</label>
                                            <select class="form-control" name="start_time" id="start_time">
                                                <option>Pilih Sesi</option>
                                            </select>
                                            @error('start_time')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-3 custom-col">
                                            <label class="form-label" for="end_time">SKS (Per sks di kali 45 menit)</label>
                                            <select class="form-control" name="sks">
                                                <option>Pilih SKS</option>
                                                <option value='2'>2 SKS</option>
                                                <option value='3'>3 SKS</option>
                                                {{-- <option value='4'>4 SKS</option> --}}
                                            </select>
                                            @error('sks')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="necessary" class="form-label">Permohonan Keperluan</label>
                                    <textarea name="necessary" id="necessary" rows="5"
                                        class="form-control @error('necessary') border-danger @enderror">{{ old('necessary') }}</textarea>
                                    @error('necessary')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" for="file_upload">Surat Permohonan</label>
                                    <div class="col-sm-12">
                                        <div id="file-preview" class="file-preview">
                                            <label for="file-upload" id="file-label" class="btn btn-primary me-2 mb-4">Pilih
                                                File</label>
                                            <input type="file" name="file_upload" id="file-upload" hidden accept=".pdf">
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">Diperbolehkan File PDF. Maksimal ukuran 2MB</p>
                                    @error('file_upload')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
        
                                </div>
                                
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <!-- <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button> -->
                                </div>
                            </form>
                        
                    @endif

                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-5 col-xxl-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="address-title text-primary">Info Ruangan</h4>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Data Ruangan</div>
                    </div>
                    <img src="{{ asset($room->thumbnail) }}" alt="" class="w-100 rounded">
                    <h5 class="text-truncate mt-4 fw-bold">{{ $room->name }}</h5>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-label-primary">{{ $room->location }}</span>
                        <span class="badge bg-label-primary">{{ $room->capacity }} Orang</span>
                    </div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCenter">
                        Fasilitas
                       </button>
                       <!-- Modal -->
                       <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Fasilitas Ruangan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Kursi Kuliah : {{ $room->kursi_kuliah}}</li>
                                    <li class="list-group-item">Kursi Dosen : {{ $room->kursi_dosen}}</li>
                                    <li class="list-group-item">Meja Dosen : {{ $room->meja_dosen}}</li>
                                    <li class="list-group-item">AC : {{ $room->ac}}</li>
                                    <li class="list-group-item">Kipas Angin : {{ $room->kipas_angin}}</li>
                                    <li class="list-group-item">White Board : {{ $room->whiteboard}}</li>
                                    <li class="list-group-item">Penghapus : {{ $room->penghapus}}</li>
                                    <li class="list-group-item">Proyektor : {{ $room->proyektor}}</li>
                                  </ul>
                            </div>
                        </div>
                        </div>
                    </div>
                    <p>{{ $room->description }}</p>
                    <table class="table datatables-basic">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_reservation as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ asset($item->user->avatar) }}"
                                                        alt="{{ $item->user->name }}" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="/profile/{{ $item->user->slug }}"
                                                    class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $item->user->fullname }}</span></a>
                                                <small class="text-muted">{{ $item->user->nim }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ date('H:i', strtotime($item->session->start)) }} &nbsp;-&nbsp;
                                        {{ date('H:i', strtotime($item->end_time)) }}
                                    </td>
                                    <td>
                                        @if ($item->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($item->status == 'not approved')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($item->status == 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
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
    <!--/ DataTable with Buttons -->
@endsection
