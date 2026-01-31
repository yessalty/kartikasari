@extends('layouts.default')
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Pengeluaran Villa</h4>
                            <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary btn-round ml-auto">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </a>
                        </div>
                        <form method="GET" action="{{ route('pengeluaran.index') }}" class="mb-4 mt-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ request('from_date') }}">
                                </div>

                                <div class="col-md-3">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ request('to_date') }}">
                                </div>

                                {{-- <div class="col-md-2">
                                    <label>Bulan</label>
                                    <select name="month" class="form-control">
                                        <option value="">Semua</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}"
                                                {{ request('month') == $m ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div> --}}

                                <div class="col-md-2">
                                    <label>Tahun</label>
                                    <select name="year" class="form-control">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                            <option value="{{ $y }}"
                                                {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-primary mr-2">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>

                                    <a href="{{ route('pengeluaran.export.pdf', request()->query()) }}"
                                        class="btn btn-danger">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
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
                                        <th>Nama Pengeluaran</th>
                                        <th>Harga</th>
                                        <th>Tanggal</th>
                                        <th>Kategori Pengeluaran</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengeluaran as $row)
                                        <tr>
                                            <td> {{ $row->nama_pengeluaran }}</td>
                                            <td> Rp{{ number_format($row->harga, 0, ',', '.') }},- </td>
                                            <td> {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }} </td>
                                            <td> {{ $row->kategori_pengeluaran }} </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('pengeluaran.edit', $row->id_pengeluaran) }}"
                                                        class="btn btn-link btn-primary btn-lg">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('pengeluaran.destroy', $row->id_pengeluaran) }}"
                                                        method="post" class="form-hapus d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-link btn-danger">
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
                    title: 'Yakin ingin menghapus?',
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
