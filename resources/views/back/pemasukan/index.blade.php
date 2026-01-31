@extends('layouts.default')

@section('content')
<div class="page-inner">
    <h3 class="fw-bold mb-4">Laporan Pemasukan</h3>

    {{-- FILTER TANGGAL --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="date" name="tanggal_awal" class="form-control"
                value="{{ request('tanggal_awal') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="tanggal_akhir" class="form-control"
                value="{{ request('tanggal_akhir') }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('admin.pemasukan.pdf', request()->query()) }}" class="btn btn-danger">
                Export PDF
            </a>
        </div>
    </form>

    {{-- RINGKASAN --}}
    {{-- TABEL --}}
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h6>Total Pemasukan</h6>
                    <h4 class="fw-bold text-success">
                        Rp {{ number_format($totalPemasukan) }}
                    </h4>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Villa</th>
                        <th>Nama Pemesan</th>
                        <th>Total Harga</th>
                        {{-- <th>DP</th>
                        <th>Sisa</th>
                        <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanans as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                            <td>{{ $p->villa->nama_villa }}</td>
                            <td>{{ $p->user->nama }}</td>
                            <td>Rp {{ number_format($p->total_harga) }}</td>
                            {{-- <td>Rp {{ number_format($p->dp) }}</td>
                            <td>Rp {{ number_format($p->sisa_pembayaran) }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ ucfirst($p->status_pemesanan) }}
                                </span>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Tidak ada data pemasukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
