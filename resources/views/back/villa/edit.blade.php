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
                            <h4 class="card-title">Edit Villa</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('villa.update', $villa->id_villa) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="villa">Nama</label>
                                <input type="text" name="nama_villa" value="{{ $villa->nama_villa }}"
                                    class="form-control" id="text" placeholder="Masukkan Nama">
                            </div>

                            <div class="form-group">
                                <label for="villa">Harga</label>
                                <input type="number" name="harga_villa" value="{{ $villa->harga_villa }}"
                                    class="form-control" id="text" placeholder="Masukkan Harga">
                            </div>

                            <div class="form-group">
                                <label for="villa">Deskripsi</label>
                                <div class="form-group">
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" placeholder="Masukkan Deskripsi">{{ $villa->deskripsi }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="villa">Lokasi</label>
                                    <input type="text" name="lokasi" value="{{ $villa->lokasi }}" class="form-control"
                                        id="text" placeholder="Masukkan Lokasi">
                                </div>

                                <div class="form-group">
                                    <label for="villa">Jumlah Kamar</label>
                                    <input type="number" name="jumlah_kamar" value="{{ $villa->jumlah_kamar }}"
                                        class="form-control" id="text" placeholder="Masukkan Jumlah Kamar">
                                </div>

                                <div class="form-group">
                                    <label for="villa">Jumlah Kamar Mandi</label>
                                    <input type="number" name="kamar_mandi" value="{{ $villa->kamar_mandi }}"
                                        class="form-control" id="kamar_mandi" placeholder="Masukkan Jumlah Kamar">
                                </div>

                                <div class="form-group">
                                    <label for="villa">Minimal Kapasitas</label>
                                    <input type="number" name="kapasitas_min" class="form-control" id="text"
                                        placeholder="Masukkan Minimal Kapasitas" value="{{ $villa->kapasitas_min }}">
                                </div>

                                <div class="form-group">
                                    <label for="villa">Maksimal Kapasitas</label>
                                    <input type="number" name="kapasitas_max" class="form-control" id="text"
                                        placeholder="Masukkan Maksimal Kapasitas" value="{{ $villa->kapasitas_max }}">
                                </div>

                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <div class="row">
                                        @foreach ($fasilitas as $item)
                                            <div class="col-md-4">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="fasilitas[]"
                                                        value="{{ $item->id_fasilitas }}" class="form-check-input"
                                                        {{ $villa->fasilitas->contains('id_fasilitas', $item->id_fasilitas) ? 'checked' : '' }}>
                                                    {{ $item->nama_fasilitas }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select name="id_kategori" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id_kategori }}"
                                                {{ $villa->id_kategori == $item->id_kategori ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tambah Foto Villa (maks 10)</label>
                                    <input type="file" name="foto[]" id="fotoInput" class="form-control" multiple
                                        accept="image/*">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                                </div>
                        </form>

                        <div class="form-group">
                            @if ($villa->fotos->count())
                                <div class="form-group">
                                    <label for="fotovilla">Foto Villa</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach ($villa->fotos as $foto)
                                            <div class="position-relative">
                                                <label class="cover-option" style="cursor: pointer">
                                                    <input type="radio" name="cover_id" value="{{ $foto->id }}"
                                                        {{ $foto->is_cover ? 'checked' : '' }} hidden>

                                                    <div class="cover-wrapper" data-id="{{ $foto->id }}">
                                                        <img src="{{ asset('storage/' . $foto->foto) }}"
                                                            class="cover-img {{ $foto->is_cover ? 'active' : '' }}">
                                                        <span class="cover-badge {{ $foto->is_cover ? '' : 'd-none' }}">
                                                            COVER
                                                        </span>
                                                    </div>
                                                </label>

                                                <form action="{{ route('villa.foto.delete', $foto->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus foto ini?')" class="position-absolute"
                                                    style="top:5px; right:5px">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">X</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <small class="texted-muted">Klik foto untuk menjadikannya cover</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="cover_id"]').forEach(radio => {
            radio.addEventListener('change', function() {

                // reset semua
                document.querySelectorAll('.cover-img').forEach(img => {
                    img.classList.remove('active');
                });

                document.querySelectorAll('.cover-badge').forEach(badge => {
                    badge.classList.add('d-none');
                });

                // aktifkan yang dipilih
                const wrapper = this.closest('.cover-option').querySelector('.cover-wrapper');
                wrapper.querySelector('.cover-img').classList.add('active');
                wrapper.querySelector('.cover-badge').classList.remove('d-none');
            });
        });
    </script>

@endsection

<style>
    .cover-img {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .cover-img.active {
        border: 2px solid #28a745;
    }

    .cover-badge {
        position: absolute;
        top: 4px;
        left: 4px;
        background: #28a745;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .cover-wrapper {
        position: relative;
    }

    .d-none {
        display: none;
    }
</style>
