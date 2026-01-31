@extends('layouts.default')

@section('content')
    <div class="page-inner">
        <h3 class="fw-bold mb-4">Data Ulasan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>User</th>
                            <th>Villa</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ulasans as $ulasan)
                            <tr>
                                <td>{{ $ulasan->user->nama }}</td>
                                <td>{{ $ulasan->villa->nama_villa }}</td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $ulasan->rating ? 'text-warning' : 'text-muted' }}">
                                            ★
                                        </span>
                                    @endfor
                                </td>
                                <td>{{ $ulasan->komentar }}</td>
                                <td>{{ $ulasan->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('ulasan.toggle', $ulasan) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-link p-0"
                                            title="{{ $ulasan->status == 'approved' ? 'Sembunyikan ulasan' : 'Tampilkan ulasan' }}">
                                            <i
                                                class="fas
                                                    {{ $ulasan->status == 'approved' ? 'fa-eye text-success' : 'fa-eye-slash text-muted' }}
                                                    fa-lg"></i>
                                        </button>
                                    </form>
                                </td>

                                {{-- <td>
                                <form action="{{ route('admin.ulasan.destroy', $ulasan) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus ulasan ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada ulasan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
