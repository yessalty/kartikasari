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
                            <h4 class="card-title">Tambah Villa</h4>
                        </div>
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
                        <form method="POST" action="{{ route('villa.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="villa">Nama</label>
                                <input type="text" name="nama_villa" class="form-control" id="text"
                                    placeholder="Masukkan Nama" value="{{ old('nama_villa') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Harga</label>
                                <input type="number" name="harga_villa" class="form-control" id="text"
                                    placeholder="Masukkan Harga" value="{{ old('harga_villa') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" placeholder="Masukkan Deskripsi">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="villa">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" id="text"
                                    placeholder="Masukkan Lokasi" value="{{ old('lokasi') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Jumlah Kamar</label>
                                <input type="number" name="jumlah_kamar" class="form-control" id="text"
                                    placeholder="Masukkan Jumlah Kamar" value="{{ old('jumlah_kamar') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Jumlah Kamar Mandi</label>
                                <input type="number" name="kamar_mandi" class="form-control" id="text"
                                    placeholder="Masukkan Jumlah Kamar Mandi" value="{{ old('kamar_mandi') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Minimal Kapasitas</label>
                                <input type="number" name="kapasitas_min" class="form-control" id="text"
                                    placeholder="Masukkan Minimal Kapasitas" value="{{ old('kapasitas_min') }}">
                            </div>

                            <div class="form-group">
                                <label for="villa">Maksimal Kapasitas</label>
                                <input type="number" name="kapasitas_max" class="form-control" id="text"
                                    placeholder="Masukkan Maksimal Kapasitas" value="{{ old('kapasitas_max') }}">
                            </div>

                            <div class="form-group">
                                <label>Fasilitas</label>
                                <div class="row">
                                    @foreach ($fasilitas as $item)
                                        <div class="col-md-4">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="fasilitas[]" value="{{ $item->id_fasilitas }}"
                                                    class="form-check-input" {{ in_array($item->id_fasilitas, old('fasilitas', [])) ? 'checked' : '' }}>
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
                                        <option value="{{ $item->id_kategori }}" {{ old('id_kategori') == $item->id_kategori ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Foto Villa (maks 10)</label>
                                <input type="file" name="foto[]" id="fotoInput" class="form-control" multiple
                                    accept="image/*">
                            </div>

                            <div class="form-group">
                                <div id="previewFoto" class="d-flex gap-2" style="overflow-x:auto;"></div>
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

    <script>
        document.getElementById('fotoInput').addEventListener('change', function(event) {
            console.log('Event change triggered');
            const preview = document.getElementById('previewFoto');
            preview.innerHTML = '';

            const files = event.target.files;
            console.log('Number of files selected:', files.length);

            if (files.length > 10) {
                alert('Maksimal 10 foto');
                event.target.value = '';
                return;
            }

            Array.from(files).forEach((file, index) => {
                console.log('Processing file:', index, file.name, file.type);
                
                // Cek ekstensi file untuk format yang tidak didukung
                const fileName = file.name.toLowerCase();
                if (fileName.endsWith('.heic') || fileName.endsWith('.heif')) {
                    alert(`Format file ${file.name} (HEIC/HEIF) tidak didukung untuk preview. Silakan konversi ke JPG atau PNG. File ini akan diabaikan.`);
                    return;
                }
                
                if (!file.type.startsWith('image/')) {
                    console.log('Skipping non-image file:', file.name);
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(e) {
                    console.log('Reader onload for file:', index);
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '120px';
                    img.style.height = '90px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '6px';
                    img.style.border = '1px solid #ddd';

                    preview.appendChild(img);
                    console.log('Image appended to preview');
                };

                reader.onerror = function(e) {
                    console.error('Error reading file:', index, e);
                    alert(`Gagal memuat preview untuk ${file.name}. Pastikan file adalah gambar yang valid.`);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
