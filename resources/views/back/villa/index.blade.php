@extends('layouts.default') @section('content')

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
                            <h4 class="card-title">Kelola Villa</h4>
                            <a href="{{ route('villa.create') }}" class="btn btn-primary btn-round ml-auto">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-primary">
                                {{ Session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah Kamar</th>
                                        <th>Kapasitas</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($villa as $row)
                                        <tr>
                                            <td>
                                                @if ($row->cover)
                                                    <img src="{{ asset('storage/' . $row->cover->foto) }}"
                                                        class="foto-thumb">
                                                @else
                                                    <span class="text-muted">Tidak ada cover</span>
                                                @endif
                                            </td>
                                            <td> {{ $row->nama_villa }}</td>
                                            <td> Rp{{ number_format($row->harga_villa, 0, ',', '.') }},- </td>
                                            <td> {{ $row->jumlah_kamar }} </td>
                                            <td> {{ $row->kapasitas_min }} - {{ $row->kapasitas_max }} Orang</td>
                                            <td> {{ $row->kategori->nama }} </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('villa.show', $row->id_villa) }}"
                                                        class="btn btn-sm center mr-2">
                                                        <i class="fa fa-eye" style="size: 10px"></i>
                                                    </a>
                                                    <a href="{{ route('villa.edit', $row->id_villa) }}"
                                                        class="btn btn-link btn-primary btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('villa.destroy', $row->id_villa) }}"
                                                        method="post" class="form-hapus d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Data Masih Kosong</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-hapus').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection

<style>
    .foto-scroll {
        display: flex;
        gap: 8px;
        max-width: auto;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .foto-thumb {
        width: 90px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
        border: 1px solid #ddd;
    }

    .foto-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .foto-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }
</style>