@extends('layouts.default')

@section('content')

    <style>
        .villa-slide {
            height: 420px;
            object-fit: cover;
            border-radius: 10px;
        }

        .carousel-indicators li {
            background-color: #007bff;
        }
    </style>

    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <h1 class="text-white fw-bold">{{ $villa->nama_villa }}</h1>
        </div>
    </div>

    <div class="page-inner mt--5">
        <div class="card">
            <div class="card-body">

                {{-- FOTO --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Foto Villa</h5>

                    @if ($villa->fotos->count())
                        <div id="villaCarousel" class="carousel slide" data-ride="carousel">

                            {{-- Indicator --}}
                            <ol class="carousel-indicators">
                                @foreach ($villa->fotos as $index => $foto)
                                    <li data-target="#villaCarousel" data-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}">
                                    </li>
                                @endforeach
                            </ol>

                            {{-- Image --}}
                            <div class="carousel-inner">
                                @foreach ($villa->fotos as $index => $foto)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $foto->foto) }}" class="d-block w-100 villa-slide"
                                            alt="Foto Villa">
                                    </div>
                                @endforeach
                            </div>

                            {{-- Control --}}
                            <a class="carousel-control-prev" href="#villaCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>

                            <a class="carousel-control-next" href="#villaCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>

                        </div>
                    @else
                        <p class="text-muted">Tidak ada foto villa</p>
                    @endif
                </div>

                {{-- INFO --}}
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Harga:</strong> Rp{{ number_format($villa->harga_villa, 0, ',', '.') }}</p>
                        <p><strong>Lokasi:</strong> {{ $villa->lokasi }}</p>
                        <p><strong>Kategori:</strong> {{ $villa->kategori->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kamar:</strong> {{ $villa->jumlah_kamar }}</p>
                        <p><strong>Kamar Mandi:</strong> {{ $villa->kamar_mandi }}</p>
                        <p><strong>Kapasitas:</strong>
                            {{ $villa->kapasitas_min }} - {{ $villa->kapasitas_max }} Orang
                        </p>
                    </div>
                </div>

                <hr>

                {{-- DESKRIPSI --}}
                <h5>Deskripsi</h5>
                <p>{{ $villa->deskripsi }}</p>

                {{-- FASILITAS --}}
                <h5>Fasilitas</h5>
                <ul>
                    @foreach ($villa->fasilitas as $f)
                        <li>{{ $f->nama_fasilitas }}</li>
                    @endforeach
                </ul>

                <div class="mt-4">
                    <a href="{{ route('villa.index') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
