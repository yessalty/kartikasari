@extends('layouts.default')

@section('content')
    <div class="container">
        <h4 class="mb-4">Data Pemesanan</h4>

        <form class="mb-3">
            <select name="status" class="form-control w-25" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                {{-- <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option> --}}
                <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                <option value="dikonfirmasi">Dikonfirmasi</option>
                <option value="dibatalkan">Dibatalkan</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Villa</th>
                    <th>Pemesan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->villa->nama_villa }}</td>
                        <td>{{ $item->user->nama }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }} <br>
                            s/d {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}
                        </td>
                        <td>
                            @php
                                $badge = match ($item->status_pemesanan) {
                                    'menunggu_pembayaran' => 'bg-warning',
                                    'menunggu_konfirmasi'=> 'bg-info',
                                    'dikonfirmasi' => 'bg-primary',
                                    'selesai' => 'bg-success',
                                    'dibatalkan' => 'bg-danger',
                                    'ditolak' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }} text-white">
                                {{ ucfirst(str_replace('_', ' ', $item->status_pemesanan)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pemesanan.show', $item->id_pemesanan) }}"
                                class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
