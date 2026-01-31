@extends('layouts.default')
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
        </div>
    </div>
    <div class="page-inner mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Konfirmasi Pemesanan</h4>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Villa</th>
                                <th>Tanggal Check-in</th>
                                <th>Tanggal Check-out</th>
                                <th>DP</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemesanans as $row)
                                @if ($row->status_pemesanan == 'menunggu_konfirmasi')
                                    <tr>
                                        <td>{{ $row->user->nama }}</td> <!-- Menampilkan nama user -->
                                        <td>{{ $row->user->email }}</td> <!-- Menampilkan email user -->
                                        <td>{{ $row->villa->nama_villa }}</td> <!-- Menampilkan nama villa -->
                                        <td>{{ $row->tanggal_masuk }}</td> <!-- Menampilkan tanggal check-in -->
                                        <td>{{ $row->tanggal_keluar }}</td> <!-- Menampilkan tanggal check-out -->
                                        <td>Rp{{ number_format($row->dp, 0, ',', '.') }},-</td> <!-- Menampilkan total bayar -->
                                        <td><img src="{{ asset('storage/' . $row->bukti_pembayaran) }}" class="foto-thumb"></td> <!-- Menampilkan bukti pembayaran -->
                                        <td><span class="badge badge-warning">Menunggu Konfirmasi</span></td> <!-- Status menunggu konfirmasi -->
                                        <td>
                                            @if ($row->bukti_pembayaran)
                                                {{-- Tombol untuk konfirmasi pembayaran --}}
                                                {{-- Tombol untuk menolak pemesanan --}}
                                                {{-- Tombol untuk melihat detail pemesanan --}}
                                            @endif
                                        </td>

                                    </tr>

                                    {{-- Tombol untuk konfirmasi pembayaran --}}
                                    {{-- Tombol untuk menolak pemesanan --}}
                                    {{-- Tombol untuk melihat detail pemesanan --}}
                                @endif
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data konfirmasi pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection