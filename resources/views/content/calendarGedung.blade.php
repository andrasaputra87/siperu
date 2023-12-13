<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <title>Data Peminjaman | SIPERU - Aplikasi Peminjaman Ruangan </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/upr.png') }}" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            color: #333 !important;
            font-family: "open sans";
            padding: 20px;

            &.no-scroll {
                overflow: hidden;
            }
        }

        .main {
            padding-left: 40px;
            padding-right: 40px;
        }

        .col-0 {
            flex: 0 0 0%;
            max-width: 0%;
        }

        .filter-title {
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .main-row {
            &.no-menu {
                .menu {
                    transform: translate3d(-300px, 0, 0);
                }
            }
        }

        .col-menu {
            .menu-wrap {
                position: relative;
            }

            .menu {
                transition: 1s;
                position: absolute;
                width: 200px;
                left: 0;
                top: 0;
            }
        }


        .row-cards {
            &.is-moving {
                .card {
                    &.clone {
                        transition: 1s;
                    }

                    &:nth-child(1) {
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        top: 0;
                        left: 0;
                    }

                    &:nth-child(2) {
                        opacity: 0;
                    }
                }
            }
        }

        .col-card {
            &__content {
                position: relative;
            }
        }

        .card {
            padding: 0;
            border: none;
            margin-bottom: 50px;
            box-shadow: 0 2px 14px 0 rgba(47, 60, 83, 0.16);

            .card-body {
                padding: 30px 20px;
            }

            .card-title {
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .card-text {
                font-size: 12px;
                line-height: 1.4;
            }

            .card-list {
                font-size: 12px;
                padding-left: 15px;
            }
        }

        #btn-toggle {
            margin: 0 auto;
            margin-bottom: 20px;
            width: 200px;
            display: block;
            background: rgb(64, 191, 246);
            background: linear-gradient(90deg, rgba(64, 191, 246, 1) 0%, rgba(110, 102, 224, 1) 100%);
            border: none;
            font-size: 14px;
            padding: 15px;
            font-weight: 300;
            box-shadow: 0 2px 14px 0 rgba(47, 60, 83, 0.3);
        }

        html,
        body {
            padding: 0;
        }

        body {
            background-color: #f5f6f7;
        }

        header.tg-header {
            padding: 40px;
            margin-bottom: 40px;
            background: rgb(247, 89, 100);
            background: linear-gradient(90deg, rgba(247, 89, 100, 1) 0%, rgba(249, 148, 104, 1) 100%);
            color: #fff;
        }

        h1.tg-h1 {
            text-align: center;
            font-size: 30px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: bold;
        }

        h2.tg-h2 {
            text-align: center;
            font-size: 20px;
            letter-spacing: 1.2px;
            font-weight: 300;
        }

        hr.tg-hr {
            margin: 0 auto;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        footer.tg-footer {
            text-align: center;
            padding-bottom: 50px;
        }

        .tg-link {
            display: inline-block;
            margin: 0 20px;
            text-align: center;
            color: #278fb2;
        }

        .error-template {
            padding: 40px 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="tg-header">
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('assets/img/backgrounds/Logo_Universitas_Palangka_Raya.png') }}" width="100px"
                    height="100px" alt="logo">
            </div>
            <div class="col-8">
                <h1 class="tg-h1">Data Penjadwalan Peminjaman Ruangan</h1>
                <h2 class="tg-h2">Daftar Jadwal dari <b>{{ $building->building_name }}</b></h2>
                <a class="btn btn-dark" href="/jadwal" role="button">Home</a>
            </div>
        </div>
    </header>
    <div class="main">
        {{-- <div id="btn-toggle" class="btn btn-primary">Show / Hide Pencarian</div> --}}
        <div class="row main-row">
            <div class="col-12 col-cards">
                <div class="card border-warning mb-3">
                    <div class="card-body text-primary ">
                        <div id='calendar'></div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    </div>

    @foreach ($reservations as $event)
        <div class="modal" tabindex="-1" id="calendarModal{{ $event->rr_id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Jadwal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nama: {{ ucwords($event->user->fullname) }}</li>
                            <li class="list-group-item">Jurusan: {{ ucwords($event->dapartment_name) }}</li>
                            <li class="list-group-item">Tanggal: {{ $event->reservation_date }}</li>
                            <li class="list-group-item">Waktu Mulai: {{ $event->session->start }}</li>
                            <li class="list-group-item">Waktu Selesai: {{ $event->end_time }}</li>
                            <li class="list-group-item">SKS: {{ $event->sks }}</li>
                            <li class="list-group-item">Gedung: {{ $event->building_name }}</li>
                            <li class="list-group-item">Ruangan: {{ $event->room->name }}</li>
                            <li class="list-group-item">Keterangan: {{ $event->necessary }}</li>
                            @if ($event->status == 'approved')
                                <li class="list-group-item">
                                    <p class="text-success bg-dark">Status: Disetujui</p>
                                </li>
                            @elseif($event->status == 'pending')
                                <li class="list-group-item">
                                    <p class="text-white bg-danger">Status: Menunggu Persetujuan</p>
                                </li>
                            @elseif($event->status == 'opened')
                                <li class="list-group-item">
                                    <p class="text-dark bg-info">Status: Kelas Dibuka</p>
                                </li>
                            @elseif($event->status == 'returned')
                                <li class="list-group-item">
                                    <p class="text-white bg-primary">Status: Dikembalikan</p>
                                </li>
                            @elseif($event->status == 'off-day')
                                <li class="list-group-item">
                                    <p class="text-dark bg-warning">Status: Kelas Dibatalkan</p>
                                </li>
                            @elseif($event->status == 'reschedule')
                                <li class="list-group-item">
                                    <p class="text-whtie bg-secondary">Status: Dijadwalkan Ulang</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let btnToggle = document.querySelector('#btn-toggle');
            let rowCards = document.querySelector('.row-cards');
            let mainRow = document.querySelector('.main-row');
            let colCardAll = document.querySelectorAll('.col-card');
            let cardAll = document.querySelectorAll('.card');

            btnToggle.addEventListener('click', function() {
                if (!rowCards.classList.contains('is-moving')) {
                    mainRow.classList.toggle("no-menu");

                    for (i = 0; i < cardAll.length; i++) {
                        let clone = cardAll[i].cloneNode(true);
                        clone.classList.add("clone");
                        cardAll[i].parentElement.insertBefore(clone, cardAll[i]);

                        let top = clone.getBoundingClientRect().top;
                        let left = clone.getBoundingClientRect().left;
                        let width = clone.getBoundingClientRect().width;
                        let height = clone.getBoundingClientRect().height;


                        clone.style.position = 'fixed';
                        clone.style.top = top + 'px';
                        clone.style.left = left + 'px';
                        clone.style.width = width + 'px';
                        clone.style.height = height + 'px';
                    }

                    document.querySelector('.col-menu').classList.toggle('col-0');
                    document.querySelector('.col-menu').classList.toggle('col-4');
                    document.querySelector('.col-cards').classList.toggle('col-8');
                    document.querySelector('.col-cards').classList.toggle('col-12');
                    for (i = 0; i < colCardAll.length; i++) {
                        colCardAll[i].classList.toggle('col-4');
                        colCardAll[i].classList.toggle('col-6');
                    }
                    rowCards.classList.add('is-moving');

                    let cardCloneAll = document.querySelectorAll('.card.clone');
                    for (i = 0; i < cardCloneAll.length; i++) {
                        let top = cardAll[i].getBoundingClientRect().top;
                        let left = cardAll[i].getBoundingClientRect().left;
                        let width = cardAll[i].getBoundingClientRect().width;
                        let height = cardAll[i].getBoundingClientRect().height;

                        cardCloneAll[i].style.top = top + 'px';
                        cardCloneAll[i].style.left = left + 'px';
                        cardCloneAll[i].style.width = width + 'px';
                        cardCloneAll[i].style.height = height + 'px';
                    }

                    setTimeout(function() {
                        rowCards.classList.remove('is-moving');
                        for (i = 0; i < cardCloneAll.length; i++) {
                            cardCloneAll[i].remove();
                        }
                    }, 1000)

                }

            })


            //simulate click for thumbnail 
            setTimeout(function() {
                document.getElementById('btn-toggle').click();
            }, 500);
            setTimeout(function() {
                document.getElementById('btn-toggle').click();
            }, 2500)
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: @json($events),
                eventClick: function(info) {
                    console.log(info.event.id);
                    $('#calendarModal' + info.event.id).modal('show');
                    // info.el.style.backgroundColor = info.event.backgroundColor;
                }
            });
            calendar.render();
            @if ($cari)
                calendar.gotoDate('{{ $cari }}');
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dropdown1').on('change', function() {
                var lantai = $(this).val();
                if (lantai) {
                    $.ajax({
                        url: '{{ url('get-ruangan') }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "lantai": lantai
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#dropdown2').empty();
                            $.each(data, function(id, name) {
                                $('#dropdown2').append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#dropdown2').empty();
                }
            });
        });
    </script>
</body>

</html>
