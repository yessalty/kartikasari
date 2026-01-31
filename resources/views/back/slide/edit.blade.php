@extends('layouts.default')

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5"></div>
</div>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Edit Slide</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('slide.update', $slide->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Preview gambar lama --}}
                        @if ($slide->gambar_slide)
                            <div class="mb-3">
                                <label class="form-label">Gambar Saat Ini</label><br>
                                <img src="{{ asset('storage/'.$slide->gambar_slide) }}"
                                     width="200"
                                     class="img-thumbnail">
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Ganti Gambar (Opsional)</label>
                            <input type="file"
                                   name="gambar_slide"
                                   class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ $slide->status ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ !$slide->status ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('slide.index') }}"
                               class="btn btn-secondary btn-sm mr-2">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
