<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kartikasari</title>

    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .villa-card {
            border-radius: 14px;
            transition: all 0.25s ease;
        }

        .villa-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.386);
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

        .navbar{
            background: rgb(49, 52, 60) !important;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="bg-light text-dark">

    {{-- NAVBAR --}}
    @include('includes.navbar-landing')

    <div class="container-fluid" style="width: 100%; margin-top:35px;">
        <div class="page-inner py-4">
            <h1 class="fw-bold mb-4 mt-2">Villa Kartikasari</h1>

            <div class="row">
                <div class="col-12">
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
                                            {{ Str::limit($villa->deskripsi, 100) }}
                                        </p>

                                        <div class="d-flex gap-3 text-muted small mb-2">
                                            <span><i class="fas fa-bed"></i> {{ $villa->jumlah_kamar }} Kamar</span>
                                            <span><i class="fas fa-bath"></i> {{ $villa->kamar_mandi }} Kamar Mandi</span>
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
                                    <small class="text-muted">/ Malam</small>

                                    <a href="{{ route('front.detail', $villa->slug) }}"
                                        class="btn btn-primary w-100 mt-3">
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

    {{-- FOOTER --}}
    @include('includes.footer-landing')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
