@extends('layouts.default')
@section('content')
    <style>
        .villa-card {
            border-radius: 14px;
            transition: all 0.25s ease;
        }

        .villa-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .villa-img-wrapper {
            height: 220px;
            overflow: hidden;
            border-radius: 14px 0 0 14px;
        }

        .villa-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .badge {
            font-size: 12px;
        }
    </style>

    <div class="container-fluid">
        <div class="page-inner py-4">
            <h1 class="fw-bold mb-4">Villa Kartikasari</h1>

            <div class="row">
                <div class="col-lg-10">
                    @foreach ($villas as $villa)
                        <div class="card villa-card mb-4 border-0 shadow-sm">
                            <div class="row g-0 align-items-center">

                                <!-- IMAGE -->
                                <div class="col-md-4">
                                    <div class="villa-img-wrapper">
                                        <img src="{{ $villa->cover ? asset('storage/' . $villa->cover->foto) : asset('images/default-villa.jpg') }}"
                                            class="villa-img" alt="{{ $villa->nama_villa }}">
                                    </div>
                                </div>

                                <!-- CONTENT -->
                                <div class="col-md-5">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-1">{{ $villa->nama_villa }}</h5>

                                        <p class="text-muted small mb-2">
                                            {{Str::limit($villa->deskripsi, 100)}}
                                        </p>

                                        <div class="d-flex gap-3 text-muted small mb-2">
                                            <span><i class="fas fa-bed"></i> {{ $villa->jumlah_kamar }} Kamar</span>
                                            <span><i class="fas fa-bath"></i> {{ $villa->kamar_mandi }} KM</span>
                                        </div>

                                        <span class="badge bg-success-subtle text-success">
                                            {{ $villa->kategori->nama }}
                                        </span>
                                    </div>
                                </div>

                                <!-- PRICE & CTA -->
                                <div class="col-md-3 text-center border-start p-3">
                                    <h5 class="fw-bold text-success mb-0">
                                        Rp {{ number_format($villa->harga_villa, 0, ',', '.') }}
                                    </h5>
                                    <small class="text-muted">/ malam</small>

                                    <a href="{{ route('front.detail', $villa->slug) }}" class="btn btn-primary w-100 mt-3">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
