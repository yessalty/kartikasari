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
        .carousel-img {
            height: 730px;
            object-fit: cover;
        }

        .carousel-caption {
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.6),
                    rgba(0, 0, 0, 0.3),
                    rgba(0, 0, 0, 0));
            padding: 30px;
            border-radius: 10px;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .hero h1 {
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 700;
        }
    </style>
</head>

<body class="bg-light text-dark">

    {{-- NAVBAR --}}
    @include('includes.navbar-landing')

    {{-- HERO / CAROUSEL --}}
    @if ($slide->count() > 0)
        <section class="mb-5">
            <div class="container-fluid p-0">
                <div id="slideCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach ($slide as $index => $s)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $s->gambar_slide) }}" class="d-block w-100 carousel-img"
                                    alt="{{ $s->judul_slide }}">

                                <div class="carousel-caption text-center">
                                    <h1 class="fw-bold display-6 mb-3">
                                        Liburan Nyaman di Villa Bernuansa Alam
                                    </h1>
                                    <p class="lead mb-4">
                                        Temukan Villa Nyaman untuk Liburan Keluarga
                                    </p>
                                    <a href="#villas" class="btn btn-primary btn-lg px-5">
                                        Jelajahi Villa
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- KENAPA PILIH KAMI --}}
    <section class="py-5">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold">🌿 Suasana Asri</h5>
                    <p class="text-muted">
                        Lingkungan tenang dengan udara sejuk pegunungan.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">🏡 Villa Nyaman</h5>
                    <p class="text-muted">
                        Bersih, luas, dan cocok untuk keluarga.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">🚗 Akses Mudah</h5>
                    <p class="text-muted">
                        Lokasi strategis dan area parkir luas.
                    </p>
                </div>
            </div>
        </div>
    </section>

   
    <section class="py-5 bg-white" id="villas">
        <div class="container">
            <h2 class="fw-bold mb-4">Rekomendasi Villa</h2>

            <div class="row g-4">
                @foreach ($villa as $v)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $v->cover->foto) }}" class="card-img-top"
                                style="height:300px; object-fit:cover; border-radius:0.5rem;" alt="{{ $v->nama }}">

                            <div class="card-body">
                                <h5 class="fw-bold">{{ $v->nama_villa }}</h5>
                                <p class="text-muted small">
                                    {{ Str::limit($v->deskripsi, 80) }}
                                </p>
                                <h5 class="fw-bold">
                                    Rp {{ number_format($v->harga_villa, 0, ',', '.') }} / Malam
                                </h5>
                                <a href="{{ route('front.detail', $v->slug) }}" class="btn btn-primary w-100 mt-3">
                                        Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FASILITAS --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Fasilitas Kami</h2>

            <div class="row text-center g-4">
                <div class="col-md-3">📶 WiFi Gratis</div>
                <div class="col-md-3">🚗 Parkir Luas</div>
                <div class="col-md-3">🍳 Dapur Lengkap</div>
                <div class="col-md-3">🌄 View Alam</div>
            </div>
        </div>
    </section>

    {{-- CTA BOOKING --}}
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Siap Liburan?</h2>
            <p class="text-muted mb-4">
                Pesan sekarang dan nikmati pengalaman menginap yang nyaman
            </p>
            <a href="{{ route('front.dashboard') }}" class="btn btn-secondary btn-lg px-5">
                Pesan Sekarang
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    @include('includes.footer-landing')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 730) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('navbar-transparent');
            } else {
                navbar.classList.add('navbar-transparent');
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>

</html>
