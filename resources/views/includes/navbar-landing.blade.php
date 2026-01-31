<style>
    /* Navbar awal (transparan) */
    .navbar-transparent {
        background: transparent;
        transition: all 0.3s ease;
    }

    /* Warna teks saat transparan */
    .navbar-transparent .nav-link,
    .navbar-transparent .navbar-brand {
        color: #fff;
    }

    /* Navbar setelah scroll */
    .navbar-scrolled {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(10px);
    }

    /* Warna teks setelah scroll */
    .navbar-scrolled .nav-link,
    .navbar-scrolled .navbar-brand {
        color: #212529;
    }
</style>

<div class="main-header">
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
        <div class="container-fluid px-5">
            <a class="navbar-brand fw-bold" href="/">Kartikasari</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center" gap-lg-3>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.villa') }}">Villa</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#fasilitas">Fasilitas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li> --}}

                    @auth
                        <li class="nav-item ms-3">
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                Login
                            </a>
                        </li>

                        @if (Route::has('register'))
                            <li class="nav-item ms-3">
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                    Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>
