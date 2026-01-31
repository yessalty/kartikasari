@extends('layouts.default')

@section('content')
<div class="container">
    <h2 class="mb-4 mt-4">Detail Pemesanan</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><b>Villa:</b> {{ $pemesanan->villa->nama_villa }}</p>
            <p><b>Pemesan:</b> {{ $pemesanan->user->nama }}</p>
            <p><b>No. HP:</b> {{ $pemesanan->user->no_hp }}</p>
            <p><b>Alamat:</b> {{ $pemesanan->user->alamat }}</p>
            <p><b>Jumlah Penginap:</b> {{ $pemesanan->jml_penginap }}</p>
            <p><b>Jumlah Kendaraan:</b> {{ $pemesanan->jml_kendaraan }}</p>
            @if ($pemesanan->extras && $pemesanan->extras->count())
                <p><b>Extra Sewa:</b>
                    @foreach ($pemesanan->extras as $extra)
                        {{ $extra->nama_extra }} ({{ $extra->pivot->jumlah }} Buah)
                    @endforeach
                </p>
            @else
                <p><b>Extra Sewa:</b> Tidak ada</p>
            @endif

            <p><b>Tanggal:</b> {{ \Carbon\Carbon::parse($pemesanan->tanggal_masuk)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($pemesanan->tanggal_keluar)->format('d M Y') }}</p>
            <p><b>Status:</b> {{ ucfirst($pemesanan->status_pemesanan) }}</p>
            <p><b>Jenis Pembayaran:</b> {{ ucfirst($pemesanan->jenis_pembayaran) }}</p>
            <p><b>Total Harga:</b> Rp {{ number_format($pemesanan->total_harga) }}</p>
            <p><b>DP:</b> Rp {{ number_format($pemesanan->dp) }}</p>
            <p><b>Sisa Pembayaran:</b> Rp {{ number_format($pemesanan->sisa_pembayaran) }}</p>
        </div>
    </div>

    @if ($pemesanan->pembayaran && $pemesanan->pembayaran->isNotEmpty())
        <div class="card mb-3">
            <div class="card-body">
                <h3>Bukti Pembayaran</h3>
                <img src="{{ asset('storage/'.$pemesanan->pembayaran->first()->bukti_pembayaran) }}"
                     class="img-fluid" width="300">
            </div>
        </div>
    @endif

    <div class="d-flex gap-2">
        @if ($pemesanan->status_pemesanan == 'menunggu_konfirmasi')
            <form action="{{ route('admin.pemesanan.konfirmasi', $pemesanan->id_pemesanan) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success">Konfirmasi</button>
            </form>

            <button type="button" class="btn btn-danger ml-2" data-toggle="modal" data-target="#modalTolak">Tolak</button>
        @endif
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" >
    <div class="modal-dialog">
        <form action="{{ route('admin.pemesanan.tolak', $pemesanan->id_pemesanan) }}"
              method="POST">
            @csrf
            @method('PATCH')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <div class="modal-body">
                    <textarea name="alasan_ditolak"
                              class="form-control"
                              rows="4"
                              required
                              placeholder="Masukkan alasan penolakan..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Konfirmasi Tolak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
