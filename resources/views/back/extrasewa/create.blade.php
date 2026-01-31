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
                            <h4 class="card-title">Tambah Extra Sewa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('extra.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="extra">Nama</label>
                                <input type="text" name="nama_extra" class="form-control" id="text"
                                    placeholder="Masukkan Nama">
                            </div>

                            <div class="form-group">
                                <label for="extra">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" placeholder="Masukkan Deskripsi"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="extra">Harga</label>
                                <input type="number" name="harga" class="form-control" id="text"
                                    placeholder="Masukkan Harga">
                            </div>

                            {{-- <div class="form-group">
                                <label for="extra">Stok</label>
                                <input type="number" name="satuan" class="form-control" id="text"
                                    placeholder="Masukkan Stok">
                            </div> --}}

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
