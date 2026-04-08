@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Risiko</h1>

        <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
            <form action="{{ route('admin.risks.update', $risk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Agensi</label>
                    <p class="text-gray-800 text-lg">{{ $risk->agency->nama_agensi ?? 'N/A' }}</p>
                    <span class="text-xs text-gray-500">(Tidak boleh diubah)</span>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Aset</label>
                    <p class="text-gray-800 text-lg">{{ $risk->asset->nama_aset ?? 'N/A' }}</p>
                    <span class="text-xs text-gray-500">(Tidak boleh diubah)</span>
                </div>

                <!-- Risk Information -->
                <hr class="my-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Maklumat Risiko</h2>

                <div class="mb-6">
                    <label for="impak" class="block text-gray-700 font-semibold mb-2">Impak (1-5) <span
                            class="text-red-600">*</span></label>
                    <input type="number" name="impak" id="impak" min="1" max="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('impak', $risk->impak) }}"
                        required>
                    @error('impak')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="kebarangkalian" class="block text-gray-700 font-semibold mb-2">Kebarangkalian (1-5) <span
                            class="text-red-600">*</span></label>
                    <input type="number" name="kebarangkalian" id="kebarangkalian" min="1" max="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded"
                        value="{{ old('kebarangkalian', $risk->kebarangkalian) }}" required>
                    @error('kebarangkalian')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="my-6">

                <div class="mb-6">
                    <label for="kawalan_sediada" class="block text-gray-700 font-semibold mb-2">Kawalan Sediada</label>
                    <textarea name="kawalan_sediada" id="kawalan_sediada" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('kawalan_sediada', $risk->kawalan_sediada) }}</textarea>
                    @error('kawalan_sediada')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="plan_mitigasi" class="block text-gray-700 font-semibold mb-2">Pelan Mitigasi</label>
                    <textarea name="plan_mitigasi" id="plan_mitigasi" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('plan_mitigasi', $risk->plan_mitigasi) }}</textarea>
                    @error('plan_mitigasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="pemilik_risiko" class="block text-gray-700 font-semibold mb-2">Pemilik Risiko</label>
                    <input type="text" name="pemilik_risiko" id="pemilik_risiko"
                        class="w-full px-4 py-2 border border-gray-300 rounded"
                        value="{{ old('pemilik_risiko', $risk->pemilik_risiko) }}">
                    @error('pemilik_risiko')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Kemaskini
                    </button>
                    <a href="{{ route('admin.risks.index') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
