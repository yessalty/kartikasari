@extends('layouts.default')

@section('content')
    <div class="container my-5">

        <style>
            .extra-jumlah:disabled {
                background-color: #f1f1f1;
                cursor: not-allowed;
            }
        </style>

        <script>
            const bookedDates = @json($bookedDates);
            const hargaPerMalam = {{ $villa->harga_villa }};
        </script>

        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-7 mx-auto">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pemesanan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_villa" value="{{ $villa->id_villa }}">

                    <!-- CARD BOOKING -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">

                            <h4 class="mb-4 fw-bold">Booking Villa</h4>

                            <!-- Villa -->
                            <div class="mb-3">
                                <label class="form-label">Villa</label>
                                <input type="text" class="form-control" value="{{ $villa->nama_villa }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->nama }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->no_hp ?? '-' }}"
                                    disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->alamat ?? '-' }}"
                                    disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Penginap</label>
                                <input type="number" class="form-control" value="{{ old('jml_penginap') }}" required
                                    name="jml_penginap">
                            </div>

                            <div class="mb-3">
                                <label>Jumlah Kendaraan</label>
                                <input type="text" name="jml_kendaraan" class="form-control">
                            </div>

                            <!-- Tanggal -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Masuk</label>
                                    <input type="text" id="tanggal_masuk" name="tanggal_masuk" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Keluar</label>
                                    <input type="text" id="tanggal_keluar" name="tanggal_keluar" class="form-control"
                                        required>
                                </div>
                            </div>

                            <label class="fw-bold mt-3">Metode Pembayaran</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_pembayaran" value="penuh"
                                    checked>
                                <label class="form-check-label">
                                    Bayar Penuh (Disarankan)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_pembayaran" value="dp">
                                <label class="form-check-label">
                                    DP 30%
                                </label>
                            </div>

                            <!-- Extra -->
                            <div class="mt-4">
                                <h5 class="fw-bold mb-3">Extra Sewa (Opsional)</h5>
                                @foreach ($extras as $extra)
                                    <div class="d-flex align-items-center gap-3 mb-2 ml-3 extra-row">
                                        <input type="checkbox" class="form-check-input extra-checkbox"
                                            data-harga="{{ $extra->harga }}" name="extras[{{ $extra->id_extra }}][id]"
                                            value="{{ $extra->id_extra }}">

                                        <span class="flex-grow-1 mt-1 ml-2">{{ $extra->nama_extra }}</span>

                                        <input type="number" class="form-control w-25 extra-jumlah"
                                            name="extras[{{ $extra->id_extra }}][jumlah]" min="1" value="1"
                                            readonly>

                                        <small class="text-muted">
                                            Rp {{ number_format($extra->harga, 0, ',', '.') }} / malam
                                        </small>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!-- RINGKASAN HARGA -->
                    <div class="card bg-light shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Ringkasan Harga</h5>

                            <div class="d-flex justify-content-between">
                                <span>Jumlah Malam</span>
                                <span id="jumlah_malam">0</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Harga Villa</span>
                                <span>Rp <span id="harga_villa">0</span></span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Total Extra</span>
                                <span>Rp <span id="total_extra">0</span></span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fw-bold fs-5 text-success">
                                <span>Total Harga</span>
                                <span>Rp <span id="total_harga">0</span></span>
                            </div>

                            <div class="d-flex justify-content-between text-danger mt-2">
                                <span>DP (30%)</span>
                                <span>Rp <span id="dp">0</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Pesan Sekarang
                    </button>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =========================
               PREPARE DISABLED DATES
            ========================== */
            const disabledRanges = bookedDates.map(item => {
                const end = new Date(item.tanggal_keluar);
                end.setDate(end.getDate() + 1); // blok hari terakhir

                return {
                    from: item.tanggal_masuk,
                    to: end.toISOString().split('T')[0]
                };
            });

            const tanggalMasuk = document.getElementById('tanggal_masuk');
            const tanggalKeluar = document.getElementById('tanggal_keluar');

            /* =========================
            FLATPICKR INIT
            ========================== */
            const masukPicker = flatpickr(tanggalMasuk, {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: disabledRanges,
                onChange: function(selectedDates, dateStr) {
                    keluarPicker.clear();
                    keluarPicker.set("minDate", dateStr);
                }
            });

            const keluarPicker = flatpickr(tanggalKeluar, {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: disabledRanges,
                onChange: function() {
                    calculatePrice();
                }
            });

            /* =========================
               HITUNG HARGA
            ========================== */
            function calculatePrice() {
                if (!tanggalMasuk.value || !tanggalKeluar.value) return;

                const start = new Date(tanggalMasuk.value);
                const end = new Date(tanggalKeluar.value);

                if (end <= start) return;

                const nights = (end - start) / (1000 * 60 * 60 * 24);
                const totalVilla = nights * hargaPerMalam;

                let totalExtra = 0;

                document.querySelectorAll('.extra-checkbox:checked').forEach(cb => {
                    const row = cb.closest('.extra-row');
                    const jumlah = parseInt(row.querySelector('.extra-jumlah').value || 1);
                    const harga = parseInt(cb.dataset.harga);

                    totalExtra += harga * jumlah * nights;
                });

                const total = totalVilla + totalExtra;
                const dp = total * 0.3;

                document.getElementById('jumlah_malam').innerText = nights;
                document.getElementById('harga_villa').innerText = totalVilla.toLocaleString('id-ID');
                document.getElementById('total_extra').innerText = totalExtra.toLocaleString('id-ID');
                document.getElementById('total_harga').innerText = total.toLocaleString('id-ID');
                document.getElementById('dp').innerText = dp.toLocaleString('id-ID');
            }

            /* =========================
               EXTRA CHECKBOX LOGIC
            ========================== */
            document.querySelectorAll('.extra-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const jumlahInput = this.closest('.extra-row').querySelector('.extra-jumlah');
                    jumlahInput.readOnly = !this.checked;
                    calculatePrice();
                });
            });

            document.querySelectorAll('.extra-jumlah').forEach(input => {
                input.addEventListener('input', calculatePrice);
            });

        });
    </script>

    <!-- SCRIPT -->
    {{-- <script>
        // function isDateBooked(date) {
        //     return bookedDates.some(item => {
        //         let start = new Date(item.tanggal_masuk);
        //         let end = new Date(item.tanggal_keluar);
        //         return date >= start && date < end;
        //     });
        // }

        function isRangeBooked(start, end) {
            return bookedDates.some(item => {
                let bookedStart = new Date(item.tanggal_masuk);
                let bookedEnd = new Date(item.tanggal_keluar);

                return start < bookedEnd && end > bookedStart;
            });
        }

        function calculatePrice() {
            let masuk = document.getElementById('tanggal_masuk').value;
            let keluar = document.getElementById('tanggal_keluar').value;

            if (!masuk || !keluar) return;

            let start = new Date(masuk);
            let end = new Date(keluar);

            if (end <= start) {
                alert('Tanggal keluar harus setelah tanggal masuk');
                return;
            }

            let nights = (end - start) / (1000 * 60 * 60 * 24);
            let totalVilla = nights * hargaPerMalam;
            let totalExtra = 0;

            document.querySelectorAll('.extra-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const row = this.closest('.extra-row');
                    const jumlahInput = row.querySelector('.extra-jumlah');
                    // const hiddenInput = row.querySelector('.extra-jumlah-hidden');

                    if (this.checked) {
                        jumlahInput.readOnly = false;
                        hiddenInput.value = jumlahInput.value;
                    } else {
                        jumlahInput.readOnly = true;
                        hiddenInput.value = '';
                    }

                    calculatePrice();
                });
            });

            document.querySelectorAll('.extra-jumlah').forEach(input => {
                input.addEventListener('input', function() {
                    const hiddenInput = this.closest('.extra-row')
                        .querySelector('.extra-jumlah-hidden');

                    hiddenInput.value = this.value;
                    calculatePrice();
                });
            });

            // document.querySelectorAll('.extra-checkbox').forEach(cb => {
            //     if (cb.checked) {
            //         let jumlah = cb.closest('div').querySelector('.extra-jumlah').value;
            //         let harga = cb.dataset.harga;
            //         totalExtra += harga * jumlah * nights;
            //     }
            // });

            let total = totalVilla + totalExtra;
            let dp = total * 0.3;

            document.getElementById('jumlah_malam').innerText = nights;
            document.getElementById('harga_villa').innerText = totalVilla.toLocaleString('id-ID');
            document.getElementById('total_extra').innerText = totalExtra.toLocaleString('id-ID');
            document.getElementById('total_harga').innerText = total.toLocaleString('id-ID');
            document.getElementById('dp').innerText = dp.toLocaleString('id-ID');
        }

        // Event tanggal
        ['tanggal_masuk', 'tanggal_keluar'].forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                let masuk = tanggal_masuk.value;
                let keluar = tanggal_keluar.value;

                if (!masuk || !keluar) return;

                let start = new Date(masuk);
                let end = new Date(keluar);

                if (isRangeBooked(start, end)) {
                    alert('Tanggal yang dipilih sudah dibooking');
                    this.value = '';
                    return;
                }

                calculatePrice();
            });
        });

        // Extra checkbox
        document.querySelectorAll('.extra-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                let jumlah = this.closest('div').querySelector('.extra-jumlah');
                jumlah.disabled = !this.checked;
                calculatePrice();
            });
        });

        document.querySelectorAll('.extra-jumlah').forEach(input => {
            input.addEventListener('change', calculatePrice);
        });

        document.addEventListener('DOMContentLoaded', function() {
            calculatePrice();
        });
    </script> --}}
@endsection
