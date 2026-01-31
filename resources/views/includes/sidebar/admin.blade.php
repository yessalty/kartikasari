<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('back/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            Hizrian
                            <span class="user-level">Administrator</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                {{-- <li class="nav-item active">
                    <a href="">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('villa.index')}}">
                        <i class="fas fa-warehouse"></i>
                        <p>Kelola Villa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.pemesanan.index') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <p>Pemesanan</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="">
                        <i class="fas fa-ban"></i>
                        <p>Pembatalan</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('pengeluaran.index')}}">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Pengeluaran</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('extra.index')}}">
                        <i class="fas fa-bed"></i>
                        <p>Extra Sewa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('fasilitas.index')}}">
                        <i class="fas fa-swimming-pool"></i>
                        <p>Fasilitas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kategori.index')}}">
                        <i class="fas fa-hotel"></i>
                        <p>Kategori</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href=" {{ route('admin.pemasukan.index') }}">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Pendapatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('ulasan.index') }}">
                        <i class="fas fa-star"></i>
                        <p>Ulasan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('slide.index') }}">
                        <i class="fas fa-images"></i>
                        <p>Slide</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('konfirmasi.index') }}">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Konfirmasi Pesan</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="">
                        <i class="fas fa-user"></i>
                        <p>Pengguna</p>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
