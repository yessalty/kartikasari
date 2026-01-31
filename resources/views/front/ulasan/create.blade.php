@extends('layouts.default')

@section('content')
    <style>
        .star-rating {
            display: inline-flex;
            flex-direction: row-reverse;
        }

        .star-rating input {
            position: absolute;
            left: -9999px;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        .star-rating label {
            font-size: 80px !important;
            color: #ccc !important;
            cursor: pointer;
            /* transition: 0.2s; */
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked+label,
        .star-rating input:checked+label~label {
            color: gold !important;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <h3 class="fw-bold mb-3">Beri Ulasan</h3>
            <h1>{{ $pemesanan->villa->nama_villa }}</h1>

            <form action="{{ route('ulasan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pemesanan" value="{{ $pemesanan->id_pemesanan }}">

                <div class="mb-3">
                    <label class="fw-bold d-block mb-2">Rating</label>

                    <div class="star-rating">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">
                            Nilai pengalaman menginap Anda dari 1 (buruk) sampai 5 (sangat puas)
                    </small>
                </div>

                <div class="mb-3">
                    <label>Komentar</label>
                    <textarea name="komentar" class="form-control" rows="4" placeholder="Ceritakan pengalaman Anda selama menginap..."></textarea>
                </div>

                <button class="btn btn-success mt-3">Kirim Ulasan</button>
            </form>
        </div>
    </div>
@endsection
