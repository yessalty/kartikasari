@extends('layouts.default') @section('content')
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
                            <h4 class="card-title">Edit Fasilitas Villa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fasilitas.update', $fasilitas->id_fasilitas)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="fasilitas">Nama Fasilitas</label>
                                <input type="text" name="nama_fasilitas" value="{{$fasilitas->nama_fasilitas}}" class="form-control" id="text" placeholder="Masukkan Nama Fasilitas">
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
