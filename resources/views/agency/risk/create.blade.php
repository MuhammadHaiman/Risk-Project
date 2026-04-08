@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('agency.risks.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Risiko Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
            <form action="{{ route('agency.risks.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="aset_id" class="block text-gray-700 font-semibold mb-2">Aset <span
                            class="text-red-600">*</span></label>
                    <select name="aset_id" id="aset_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded @error('aset_id') border-red-500 @enderror"
                        required>
                        <option value="">Pilih Aset</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}" @selected(old('aset_id') == $asset->id)>{{ $asset->nama_aset }}
                            </option>
                        @endforeach
                    </select>
                    @error('aset_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 1: Select Kategori Risiko -->
                <div class="mb-6 p-4 bg-blue-50 rounded border border-blue-200">
                    <label for="kategori_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-flag text-blue-600"></i> Langkah 1: Kategori Risiko <span
                            class="text-red-600">*</span>
                    </label>
                    <select name="kategori_id" id="kategori_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded @error('kategori_id') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Kategori Risiko Terlebih Dahulu --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 2: Select Sub Kategori -->
                <div class="mb-6 p-4 bg-green-50 rounded border border-green-200">
                    <label for="sub_kategori_risiko_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-sitemap text-green-600"></i> Langkah 2: Sub-Kategori Risiko <span
                            class="text-red-600">*</span>
                    </label>
                    <select name="sub_kategori_risiko_id" id="sub_kategori_risiko_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded @error('sub_kategori_risiko_id') border-red-500 @enderror"
                        required disabled>
                        <option value="">-- Pilih Kategori Terlebih Dahulu --</option>
                    </select>
                    @error('sub_kategori_risiko_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 3: Select Risiko -->
                <div class="mb-6 p-4 bg-purple-50 rounded border border-purple-200">
                    <label for="risiko_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-warning text-purple-600"></i> Langkah 3: Risiko <span class="text-red-600">*</span>
                    </label>
                    <select name="risiko_id" id="risiko_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded @error('risiko_id') border-red-500 @enderror"
                        required disabled>
                        <option value="">-- Pilih Sub-Kategori Terlebih Dahulu --</option>
                    </select>
                    @error('risiko_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Step 4: Select Punca Risiko -->
                <div class="mb-6 p-4 bg-orange-50 rounded border border-orange-200">
                    <label for="punca_risiko_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-link text-orange-600"></i> Langkah 4: Punca Risiko <span
                            class="text-red-600">*</span>
                    </label>
                    <select name="punca_risiko_id" id="punca_risiko_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded @error('punca_risiko_id') border-red-500 @enderror"
                        required disabled>
                        <option value="">-- Pilih Kategori Risiko Terlebih Dahulu --</option>
                    </select>
                    @error('punca_risiko_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="my-6">

                <div class="mb-6">
                    <label for="impak" class="block text-gray-700 font-semibold mb-2">Impak (1-5) <span
                            class="text-red-600">*</span></label>
                    <input type="number" name="impak" id="impak" min="1" max="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('impak') }}" required>
                    @error('impak')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kebarangkalian" class="block text-gray-700 font-semibold mb-2">Kebarangkalian (1-5) <span
                            class="text-red-600">*</span></label>
                    <input type="number" name="kebarangkalian" id="kebarangkalian" min="1" max="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('kebarangkalian') }}"
                        required>
                    @error('kebarangkalian')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kawalan_sediada" class="block text-gray-700 font-semibold mb-2">Kawalan Sediada</label>
                    <textarea name="kawalan_sediada" id="kawalan_sediada" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('kawalan_sediada') }}</textarea>
                    @error('kawalan_sediada')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="plan_mitigasi" class="block text-gray-700 font-semibold mb-2">Pelan Mitigasi</label>
                    <textarea name="plan_mitigasi" id="plan_mitigasi" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('plan_mitigasi') }}</textarea>
                    @error('plan_mitigasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="pemilik_risiko" class="block text-gray-700 font-semibold mb-2">Pemilik Risiko</label>
                    <input type="text" name="pemilik_risiko" id="pemilik_risiko"
                        class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('pemilik_risiko') }}">
                    @error('pemilik_risiko')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('agency.risks.index') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategori_id');
            const subKategoriSelect = document.getElementById('sub_kategori_risiko_id');
            const risikoSelect = document.getElementById('risiko_id');
            const puncaSelect = document.getElementById('punca_risiko_id');

            // When Kategori is selected
            kategoriSelect.addEventListener('change', function() {
                const kategoriId = this.value;

                // Reset dependent dropdowns
                subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub-Kategori --</option>';
                risikoSelect.innerHTML = '<option value="">-- Pilih Risiko --</option>';
                puncaSelect.innerHTML = '<option value="">-- Pilih Punca Risiko --</option>';

                subKategoriSelect.disabled = true;
                risikoSelect.disabled = true;
                puncaSelect.disabled = true;

                if (kategoriId) {
                    // Fetch sub-categories
                    fetch(`/api/subcategories/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                subKategoriSelect.disabled = false;
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.nama;
                                    subKategoriSelect.appendChild(option);
                                });
                            }
                        });

                    // Fetch causes for this category
                    fetch(`/api/causes/${kategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                puncaSelect.disabled = false;
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.nama;
                                    puncaSelect.appendChild(option);
                                });
                            }
                        });
                }
            });

            // When Sub-Kategori is selected
            subKategoriSelect.addEventListener('change', function() {
                const subKategoriId = this.value;

                // Reset risiko dropdown
                risikoSelect.innerHTML = '<option value="">-- Pilih Risiko --</option>';
                risikoSelect.disabled = true;

                if (subKategoriId) {
                    // Fetch risks
                    fetch(`/api/risks/${subKategoriId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                risikoSelect.disabled = false;
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    option.textContent = item.nama;
                                    risikoSelect.appendChild(option);
                                });
                            }
                        });
                }
            });

            // Restore values if form had validation errors
            const oldKategori = '{{ old('kategori_id') }}';
            const oldSubKategori = '{{ old('sub_kategori_risiko_id') }}';
            const oldRisiko = '{{ old('risiko_id') }}';
            const oldPunca = '{{ old('punca_risiko_id') }}';

            if (oldKategori) {
                kategoriSelect.value = oldKategori;
                kategoriSelect.dispatchEvent(new Event('change'));

                // Set old sub-kategori after subcategories load
                setTimeout(() => {
                    if (oldSubKategori) {
                        subKategoriSelect.value = oldSubKategori;
                        subKategoriSelect.dispatchEvent(new Event('change'));
                    }
                    if (oldPunca) {
                        puncaSelect.value = oldPunca;
                    }
                }, 500);

                // Set old risiko after risks load
                setTimeout(() => {
                    if (oldRisiko) {
                        risikoSelect.value = oldRisiko;
                    }
                }, 1000);
            }
        });
    </script>
@endsection
