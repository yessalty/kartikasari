@extends('layouts.default')
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <h1 class="pb-2 fw-bold text-white">Pesanan Saya</h1>
        </div>
    </div>

    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mt--2">
                            <div class="col-md-9 col-lg-10 p-4">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                @forelse ($pemesanans as $pemesanan)
                                    @php
                                        $tanggalMasuk = \Carbon\Carbon::parse($pemesanan->tanggal_masuk);
                                        $batasBatal = $tanggalMasuk->copy()->subDay();
                                        $bolehBatal = now()->lessThanOrEqualTo($batasBatal);

                                        $badge = match ($pemesanan->status_pemesanan) {
                                            'menunggu_pembayaran' => 'bg-warning',
                                            'menunggu_konfirmasi' => 'bg-info',
                                            'dikonfirmasi' => 'bg-primary',
                                            'selesai' => 'bg-success',
                                            'dibatalkan' => 'bg-danger',
                                            'ditolak' => 'bg-danger',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <div class="card mb-4 shadow-sm">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-4">
                                                <div class="villa-img-wrapper">
                                                    <img src="{{ $pemesanan->villa->cover ? asset('storage/' . $pemesanan->villa->cover->foto) : asset('images/default-villa.jpg') }}"
                                                        class="img-fluid villa-img"
                                                        alt="{{ $pemesanan->villa->nama_villa }}">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title fw-bold">{{ $pemesanan->villa->nama_villa }}</h5>

                                                    <p class="text-muted mb-1">Tanggal Masuk :
                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($pemesanan->tanggal_masuk)->format('d M Y') }}
                                                        </strong>
                                                    </p>

                                                    <p class="text-muted mb-1">Tanggal Keluar :
                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($pemesanan->tanggal_keluar)->format('d M Y') }}
                                                        </strong>
                                                    </p>

                                                    <p class="text-muted mb-1">Batas Pembatalan Pemesanan :
                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($batasBatal)->format('d M Y') }}
                                                        </strong>
                                                    </p>

                                                    <h6 class="text-success fw-bold">
                                                        Rp. {{ number_format($pemesanan->villa->harga_villa, 0, ',', '.') }}
                                                        / Malam
                                                    </h6>


                                                    <span class="badge {{ $badge }} text-white">
                                                        {{ ucfirst($pemesanan->status_pemesanan) }}

                                                    </span>
                                                    <div class="mt-3 d-flex gap-2 flex-wrap">
                                                        @if (in_array($pemesanan->status_pemesanan, ['menunggu_pembayaran', 'menunggu_konfirmasi', 'dikonfirmasi']))
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalBatal{{ $pemesanan->id_pemesanan }}">
                                                                Batalkan
                                                            </button>
                                                        @endif

                                                        @if ($pemesanan->status_pemesanan === 'menunggu_pembayaran')
                                                            <a href="{{ route('pembayaran.create', $pemesanan) }}"
                                                                class="btn btn-outline-primary btn-sm ml-2">Bayar</a>
                                                        @endif

                                                        @if ($pemesanan->status_pemesanan === 'selesai' && !$pemesanan->ulasan)
                                                            <a href="{{ route('ulasan.create', $pemesanan->id_pemesanan) }}"
                                                                class="btn btn-outline-success btn-sm">Beri Ulasan</a>
                                                        @endif
                                                    </div>

                                                    <div class="mt-3">
                                                        @if ($pemesanan->status_pemesanan == 'ditolak')
                                                            <div class="alert alert-danger mt-3">
                                                                <strong>Alasan Ditolak:</strong><br>
                                                                {{ $pemesanan->alasan_ditolak }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Batal -->
                                    <div class="modal fade" id="modalBatal{{ $pemesanan->id_pemesanan }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold text-danger">
                                                        Konfirmasi Pembatalan
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p>Dengan membatalkan pesanan ini, Anda menyetujui ketentuan berikut:
                                                    </p>

                                                    <ul class="small text-muted">
                                                        <li>Pembatalan hanya dapat dilakukan maksimal <strong>H-1 sebelum
                                                                check-in</strong></li>
                                                        <li>DP yang telah dibayarkan <strong class="text-danger">tidak dapat
                                                                dikembalikan</strong></li>
                                                        <li>Jika Pembayaran Penuh, yang dapat dikembalikan hanya <strong>75%
                                                                dari Total Harga.</strong> Pemesan akan dihubungi oleh admin
                                                            melalui wa untuk proses pengembalian dana.</li>
                                                    </ul>

                                                    <div class="alert alert-warning small mb-0">
                                                        Pastikan Anda sudah yakin sebelum melanjutkan.
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                                        Kembali
                                                    </button>

                                                    <form action="{{ route('pemesanan.batal', $pemesanan->id_pemesanan) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="btn btn-danger btn-sm">
                                                            Ya, Batalkan Pesanan
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info text-center">
                                        Kamu belum memiliki pemesanan.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
