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
                            <h4 class="card-title">Tambah Pengeluaran Villa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pengeluaran.store')}}">
                            @csrf
                            <div class="form-group">
                                <label for="pengeluaran">Nama Pengeluaran</label>
                                <input type="text" name="nama_pengeluaran" class="form-control" id="text" placeholder="Masukkan Nama Pengeluaran">
                            </div>

                            <div class="form-group">
                                <label for="pengeluaran">Harga</label>
                                <input type="number" name="harga" class="form-control" id="text" placeholder="Masukkan Harga">
                            </div>

                            <div class="form-group">
                                <label for="pengeluaran">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="text" placeholder="Masukkan Tanggal Pengeluaran">
                            </div>

                            <div class="form-group">
                                <label for="pengeluaran">Kategori</label>
                                <input type="text" name="kategori_pengeluaran" class="form-control" id="text" placeholder="Masukkan Kategori Pengeluaran">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
