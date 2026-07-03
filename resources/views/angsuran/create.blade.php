@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">
                        <i class="fas fa-plus-circle text-success me-2"></i>Tambah Angsuran Baru
                    </h1>
                    <p class="text-muted mb-0">Catat pembayaran angsuran pinjaman anggota</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('angsuran.index') }}" class="text-decoration-none">Angsuran</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle me-3 mt-1 flex-shrink-0"></i>
                        <div class="flex-grow-1">
                            <h6 class="alert-heading mb-2">Validasi Gagal</h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('angsuran.store') }}" method="POST" novalidate>
                        @csrf

                        {{-- Kode Angsuran --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-barcode text-success me-2"></i>Kode Angsuran
                            </label>
                            <input type="text"
                                   name="kode_angsuran"
                                   class="form-control form-control-lg bg-light border-0"
                                   value="{{ $kode }}"
                                   readonly
                                   style="cursor: not-allowed;">
                            <small class="text-muted d-block mt-2">Kode otomatis</small>
                        </div>

                        {{-- Pilih Pinjaman --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-file-invoice-dollar text-success me-2"></i>Pilih Pinjaman <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="text"
                                       id="pinjaman_search"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="🔍 Ketik nomor pinjaman atau nama anggota (min. 3 huruf)"
                                       value=""
                                       required
                                       style="transition: all 0.3s ease;">
                                
                                <input type="hidden"
                                       name="id_pinjaman"
                                       id="id_pinjaman"
                                       value="{{ old('id_pinjaman') }}">
                                
                                <div id="pinjaman_list"
                                     class="position-absolute w-100 bg-white border border-2 list-group list-group-flush rounded-lg shadow"
                                     style="display: none; z-index: 1000; max-height: 300px; overflow-y: auto; top: 100%; margin-top: 4px;">
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Pilih pinjaman dari daftar yang muncul</small>

                            {{-- Detail Pinjaman --}}
                            <div id="pinjaman_detail" class="mt-3" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Nama Anggota</small>
                                            <p class="fw-600 mb-0" id="detail_nama">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Jumlah Pinjaman</small>
                                            <p class="fw-600 mb-0" id="detail_pinjaman">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Saldo Pinjaman</small>
                                            <p class="fw-600 mb-0 text-danger" id="detail_saldo">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted">Angsuran Per Bulan</small>
                                            <p class="fw-600 mb-0" id="detail_angsuran">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tanggal Angsuran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-calendar-alt text-success me-2"></i>Tanggal Angsuran <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       name="tanggal_angsuran"
                                       class="form-control form-control-lg border-2 border-light"
                                       value="{{ old('tanggal_angsuran', date('Y-m-d')) }}"
                                       required
                                       style="transition: all 0.3s ease;">
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-credit-card text-success me-2"></i>Metode Pembayaran <span class="text-danger">*</span>
                                </label>
                                <select name="metode_pembayaran"
                                        class="form-select form-select-lg border-2 border-light"
                                        required
                                        style="transition: all 0.3s ease;">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>💵 Tunai</option>
                                    <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>🏦 Transfer</option>
                                    <option value="cek" {{ old('metode_pembayaran') == 'cek' ? 'selected' : '' }}>📄 Cek</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Nominal Angsuran --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-money-bill-wave text-success me-2"></i>Nominal Angsuran (Rp) <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="nominal_display"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="0"
                                       value="{{ old('nominal_angsuran') ? number_format(old('nominal_angsuran'), 0, ',', '.') : '' }}"
                                       required
                                       style="transition: all 0.3s ease;">
                                <input type="hidden"
                                       name="nominal_angsuran"
                                       id="nominal_value"
                                       value="{{ old('nominal_angsuran') }}">
                            </div>

                            {{-- Bunga --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600 text-dark">
                                    <i class="fas fa-percent text-success me-2"></i>Bunga (Rp)
                                </label>
                                <input type="text"
                                       id="bunga_display"
                                       class="form-control form-control-lg border-2 border-light"
                                       placeholder="0"
                                       value="{{ old('bunga') ? number_format(old('bunga'), 0, ',', '.') : '' }}"
                                       style="transition: all 0.3s ease;">
                                <input type="hidden"
                                       name="bunga"
                                       id="bunga_value"
                                       value="{{ old('bunga') }}">
                            </div>
                        </div>

                        {{-- Denda --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-exclamation-triangle text-success me-2"></i>Denda (Rp)
                            </label>
                            <input type="text"
                                   id="denda_display"
                                   class="form-control form-control-lg border-2 border-light"
                                   placeholder="0"
                                   value="{{ old('denda') ? number_format(old('denda'), 0, ',', '.') : '' }}"
                                   style="transition: all 0.3s ease;">
                            <input type="hidden"
                                   name="denda"
                                   id="denda_value"
                                   value="{{ old('denda') }}">
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-600 text-dark">
                                <i class="fas fa-sticky-note text-success me-2"></i>Keterangan
                            </label>
                            <textarea name="keterangan"
                                      class="form-control form-control-lg border-2 border-light"
                                      rows="3"
                                      placeholder="Masukkan keterangan tambahan (opsional)"
                                      style="transition: all 0.3s ease; resize: vertical;">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-3 mt-5">
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                                <i class="fas fa-save me-2"></i>Simpan Angsuran
                            </button>
                            <a href="{{ route('angsuran.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info alert-dismissible fade show mt-4 border-0" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Pastikan semua data yang Anda masukkan sudah benar sebelum menyimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .form-control-lg,
    .form-select-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .form-label {
        margin-bottom: 0.5rem;
        letter-spacing: 0.3px;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15) !important;
    }

    #pinjaman_list .list-group-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        border: none;
        border-bottom: 1px solid #f0f0f0;
    }

    #pinjaman_list .list-group-item:hover {
        background-color: #f8f9fa;
        padding-left: 1.5rem;
    }

    #pinjaman_list .list-group-item:last-child {
        border-bottom: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pinjaman_search');
    const hiddenInput = document.getElementById('id_pinjaman');
    const suggestionList = document.getElementById('pinjaman_list');
    const pinjamanDetail = document.getElementById('pinjaman_detail');

    // Format number input
    const formatNumberInput = (displayId, valueId) => {
        const displayInput = document.getElementById(displayId);
        const valueInput = document.getElementById(valueId);

        if (displayInput) {
            displayInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                let formatted = '';
                if (value) {
                    formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                this.value = formatted;
                valueInput.value = value || '0';
            });
        }
    };

    formatNumberInput('nominal_display', 'nominal_value');
    formatNumberInput('bunga_display', 'bunga_value');
    formatNumberInput('denda_display', 'denda_value');

    // Pinjaman autocomplete
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();

        if (query.length >= 3) {
            fetch(`/api/pinjaman/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionList.innerHTML = '';
                    
                    if (data.length > 0) {
                        data.forEach(pinjaman => {
                            const item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';
                            item.textContent = `${pinjaman.nomor_pinjaman} - ${pinjaman.anggota.nama}`;
                            item.onclick = function(e) {
                                e.preventDefault();
                                searchInput.value = `${pinjaman.nomor_pinjaman} - ${pinjaman.anggota.nama}`;
                                hiddenInput.value = pinjaman.id;
                                suggestionList.style.display = 'none';
                                updatePinjamanDetail(pinjaman);
                            };
                            suggestionList.appendChild(item);
                        });
                        suggestionList.style.display = 'block';
                    } else {
                        const item = document.createElement('div');
                        item.className = 'list-group-item text-muted text-center';
                        item.textContent = '❌ Tidak ada hasil';
                        suggestionList.appendChild(item);
                        suggestionList.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            suggestionList.style.display = 'none';
        }
    });

    // Update detail pinjaman
    function updatePinjamanDetail(pinjaman) {
        document.getElementById('detail_nama').textContent = pinjaman.anggota.nama;
        document.getElementById('detail_pinjaman').textContent = `Rp ${formatNumber(pinjaman.jumlah_pinjaman)}`;
        
        // Hitung saldo pinjaman terakhir
        const saldoTerakhir = pinjaman.saldo_terakhir || pinjaman.total_pinjaman;
        document.getElementById('detail_saldo').textContent = `Rp ${formatNumber(saldoTerakhir)}`;
        document.getElementById('detail_angsuran').textContent = `Rp ${formatNumber(pinjaman.angsuran_per_bulan)}`;
        
        pinjamanDetail.style.display = 'block';
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Sembunyikan daftar saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.position-relative')) {
            suggestionList.style.display = 'none';
        }
    });

    // Validasi form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!hiddenInput.value) {
            e.preventDefault();
            searchInput.classList.add('border-danger');
            searchInput.focus();
            alert('⚠️ Silakan pilih pinjaman dari daftar');
            return false;
        }
    });
});
</script>
@endpush
