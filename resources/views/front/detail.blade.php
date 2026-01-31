@extends('layouts.default')
@section('content')
    <style>
        .villa-img-wrapper {
            width: 100%;
            height: 540px;
            margin-bottom: 24px;
            overflow: hidden;
            border-radius: 6px;
        }

        .villa-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .villa-price {
            font-size: 24px;
            font-weight: 700;
            color: #16a34a;
        }

        .villa-price span {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
        }

        .villa-features>div {
            background: #f8fafc;
            padding: 8px 12px;
            border-radius: 8px;
            margin-left: 0;
        }

        .booking-section {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            position: sticky;
            top: 20px;
        }

        .carousel,
        .carousel-inner,
        .carousel-item {
            height: 100%;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 48px;
            height: 48px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.45);
            border-radius: 50%;
            opacity: 1;
        }

        .carousel-control-prev {
            left: 15px;
        }

        .carousel-control-next {
            right: 15px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-size: 60% 60%;
        }


        @media (max-width: 768px) {
            .villa-img-wrapper {
                height: 280px;
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <div class="container-fluid">
        <div class="row mx-auto" style="max-width: 1280px">
            <div class="col-12">
                <div class="villa-card p-4">
                    <!-- Villa Image -->
                    <div class="villa-img-wrapper">
                        @if ($photos->count())
                            <div id="villaCarousel" class="carousel slide h-100">
                                <div class="carousel-inner h-100">
                                    @foreach ($photos as $index => $foto)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                                            <img src="{{ asset('storage/' . $foto->foto) }}" class="villa-img"
                                                alt="Foto Villa">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-target="#villaCarousel"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>

                                <button class="carousel-control-next" type="button" data-target="#villaCarousel"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>

                            </div>
                        @endif
                    </div>

                    <!-- Villa Info -->
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-8">
                            <div class="villa-info">
                                <h1 class="villa-title fw-bold mb-3">{{ $villa->nama_villa }}</h1>
                                <h3 class="villa-price fs-3 fw-bold text-success">
                                    Rp{{ number_format($villa->harga_villa, 0, ',', '.') }},- / Malam</h3>

                                <!-- Villa Features -->
                                <div class="villa-features d-flex gap-4 mb-4 flex-wrap">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-door-closed fs-5"></i>
                                        <span class="fw-medium">{{ $villa->jumlah_kamar }} Kamar Tidur</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-6">
                                        <i class="bi bi-droplet fs-5"></i>
                                        <span class="fw-medium">{{ $villa->kamar_mandi }} Kamar Mandi</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-6">
                                        <i class="bi bi-people fs-5"></i>
                                        <span class="fw-medium">{{ $villa->kapasitas_min }} - {{ $villa->kapasitas_max }}
                                            Orang</span>
                                    </div>
                                </div>

                                <!-- Villa Description -->
                                <div class="villa-description mb-4">
                                    <p class="text-muted">
                                        {{ $villa->deskripsi }}
                                    </p>
                                </div>

                                <!-- Facilities -->
                                <div class="villa-facilities">
                                    <h3 class="fw-bold mb-3">Fasilitas</h3>
                                    <ul class="row list-unstyled">
                                        @foreach ($villa->fasilitas as $fasilitas)
                                            <li class="col-6 mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                {{ $fasilitas->nama_fasilitas }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h3 class="fw-bold mb-3">Ulasan Pengunjung</h3>
                                @foreach ($ulasans as $ulasan)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <strong>{{ $ulasan->user->nama }}</strong>

                                            <div>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="{{ $i <= $ulasan->rating ? 'text-warning' : 'text-muted' }}">★</span>
                                                @endfor
                                            </div>

                                            <p class="mt-2">{{ $ulasan->komentar }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Booking Section -->
                        <div class="col-md-4 " style="margin-top: 3px">
                            <div class="booking-section shadow-sm">
                                <h2 style="margin-left: 10px">Cek Ketersediaan</h2>
                                <div id="calendar" style="background: #fff; padding:10px; border-radius:6px;"></div>
                                <div class="alert alert-info mt-3 small">
                                    <strong>Keterangan:</strong><br>
                                    <span class="text-danger">■</span> Sudah Dipesan<br>
                                </div>
                                <a href="{{ route('pemesanan.create', $villa->id_villa) }}"
                                    class="btn btn-dark btn-lg w-100">Pesan Sekarang</a>
                                {{-- <button type="button"  data-bs-toggle="modal" data-bs-target="#messageModal">
                                    Pesan
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400,
                events: [
                    @foreach ($pemesanan as $booking)
                        {
                            title: 'Dipesan',
                            start: '{{ $booking->tanggal_masuk }}',
                            end: '{{ \Carbon\Carbon::parse($booking->tanggal_keluar)->addDay()->toDateString() }}',
                            color: 'red'
                        },
                    @endforeach
                ]
            });
            calendar.render();

            // Carousel sudah menggunakan Bootstrap 4 attributes, tidak perlu inisialisasi manual
        });
    </script>
@endsection
