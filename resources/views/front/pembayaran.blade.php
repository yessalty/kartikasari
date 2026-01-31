@extends('layouts.default')

@section('content')
    <div class="page-inner">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <h1 class="fw-bold mb-0" style="padding: 10px; margin-left:11px;">
                        {{ $pemesanan->jenis_pembayaran === 'penuh' ? 'Pembayaran Penuh' : 'Pembayaran DP (30%)' }}
                        {{ $pemesanan->villa->nama_villa }}</h1>

                    <div class="card-body">

                        {{-- Info Harga --}}
                        <div class="mb-3">
                            <p class="mb-1 text-muted">Total Harga</p>
                            <h5 class="fw-bold">
                                Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                            </h5>
                        </div>

                        <div class="mb-4">
                            <p class="mb-1 text-muted">
                                {{ $pemesanan->jenis_pembayaran === 'penuh' ? 'Total yang Harus Dibayar' : 'DP yang Harus Dibayar (30%)' }}
                            </p>

                            <h4 class="fw-bold text-danger">
                                Rp
                                {{ number_format(
                                    $pemesanan->jenis_pembayaran === 'penuh'
                                    ? $pemesanan->total_harga 
                                    : $pemesanan->total_harga * 0.3,
                                    0,',','.',
                                )}}
                            </h4>
                        </div>

                        <div class="alert alert-info">
                            @if ($pemesanan->jenis_pembayaran === 'penuh')
                                Silakan lakukan pembayaran penuh dan upload bukti transfer.
                            @else
                                Silakan transfer sesuai nominal DP, lalu upload bukti pembayaran.
                            @endif
                        </div>

                        <hr>

                        {{-- Info Rekening --}}
                        <div class="mb-4">
                            <p class="fw-semibold mb-1">Transfer ke rekening:</p>
                            <div class="border rounded p-3 bg-light">
                                <p class="mb-1 fw-bold">BRI</p>
                                <p class="mb-1">No. Rekening: <strong>671801026736531</strong></p>
                                <p class="mb-0">a.n <strong>SRI SARJANTI</strong></p>
                            </div>
                        </div>

                        {{-- Form Upload --}}
                        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_pemesanan" value="{{ $pemesanan->id_pemesanan }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload Bukti Transfer</label>
                                <input type="file" name="bukti_pembayaran" class="form-control" required>
                                <small class="text-muted">
                                    Format JPG / PNG, maksimal 2MB
                                </small>
                            </div>

                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                Konfirmasi Pembayaran
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
