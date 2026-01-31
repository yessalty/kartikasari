@extends('layouts.default')

@section('content')
{{-- HEADER --}}
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="text-white fw-bold">Dashboard Admin</h1>
                <p class="text-white mb-0">Ringkasan data pengelolaan villa</p>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">

    {{-- KPI CARDS --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card card-stats card-primary">
                <div class="card-body">
                    <p class="card-category">Total Villa</p>
                    <h4 class="card-title">{{ $totalVilla }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats card-success">
                <div class="card-body">
                    <p class="card-category">Booking Hari Ini</p>
                    <h4 class="card-title">{{ $bookingToday }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats card-warning">
                <div class="card-body">
                    <p class="card-category">Booking Bulan Ini</p>
                    <h4 class="card-title">{{ $bookingBulanIni }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-stats card-danger">
                <div class="card-body">
                    <p class="card-category">Pendapatan Bulan Ini</p>
                    <h4 class="card-title">
                        Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT ROW --}}
    <div class="row mt-4">

        {{-- BOOKING HARI INI --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Booking Hari Ini</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Pemesan</th>
                                    <th>Villa</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookingTodayList as $booking)
                                    <tr>
                                        <td>{{ $booking->user->nama }}</td>
                                        <td>{{ $booking->villa->nama_villa }}</td>
                                        <td>{{ Carbon\Carbon::parse($booking->tanggal_masuk)->format('d M Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($booking->tanggal_keluar)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $booking->status == 'dikonfirmasi' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->status_pemesanan) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Tidak ada booking hari ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATUS VILLA --}}
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Status Villa</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($villaStatus as $villa)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $villa->nama_villa }}
                                <span class="badge badge-info">
                                    {{ ucfirst($villa->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}

    </div>

</div>
@endsection