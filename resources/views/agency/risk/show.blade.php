@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Risiko Saya</h1>
        <a href="{{ route('agency.risks.index') }}" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left"></i> Kembali ke Senarai
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column: Basic Information -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Informasi Asas</h2>
            
            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Aset</label>
                <p class="text-gray-800 text-lg">{{ $risk->asset->nama_aset ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Jenis Aset</label>
                <p class="text-gray-800 text-lg">{{ $risk->asset->jenisAset->nama ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Pemilik Risiko</label>
                <p class="text-gray-800 text-lg">{{ $risk->pemilik_risiko ?? 'Tidak ditetapkan' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Tarikh Didaftarkan</label>
                <p class="text-gray-800 text-lg">{{ $risk->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Right Column: Risk Classification -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Klasifikasi Risiko</h2>
            
            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Kategori Risiko</label>
                <p class="text-gray-800 text-lg">{{ $risk->kategoriRisiko->nama ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Sub-Kategori</label>
                <p class="text-gray-800 text-lg">{{ $risk->subKategoriRisiko->nama ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Risiko</label>
                <p class="text-gray-800 text-lg">{{ $risk->risiko->nama ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <label class="text-gray-600 font-semibold">Punca Risiko</label>
                <p class="text-gray-800 text-lg">{{ $risk->puncaRisiko->nama ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Risk Assessment -->
    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Penilaian Risiko</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <label class="text-gray-600 font-semibold">Impak</label>
                <p class="text-3xl font-bold text-blue-600">{{ $risk->impak }}</p>
                <p class="text-sm text-gray-600">Skala 1-5</p>
            </div>

            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <label class="text-gray-600 font-semibold">Kebarangkalian</label>
                <p class="text-3xl font-bold text-green-600">{{ $risk->kebarangkalian }}</p>
                <p class="text-sm text-gray-600">Skala 1-5</p>
            </div>

            <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                <label class="text-gray-600 font-semibold">Skor Risiko</label>
                <p class="text-3xl font-bold text-purple-600">{{ $risk->skor_risiko }}</p>
                <p class="text-sm text-gray-600">Impak × Kebarangkalian</p>
            </div>

            <div class="p-4 rounded
                @if ($risk->tahap_risiko === 'Tinggi')
                    bg-red-50 border-l-4 border-red-500
                @elseif ($risk->tahap_risiko === 'Sederhana')
                    bg-yellow-50 border-l-4 border-yellow-500
                @else
                    bg-green-50 border-l-4 border-green-500
                @endif
            ">
                <label class="text-gray-600 font-semibold">Tahap Risiko</label>
                <p class="text-3xl font-bold 
                    @if ($risk->tahap_risiko === 'Tinggi')
                        text-red-600
                    @elseif ($risk->tahap_risiko === 'Sederhana')
                        text-yellow-600
                    @else
                        text-green-600
                    @endif
                ">{{ $risk->tahap_risiko }}</p>
            </div>
        </div>
    </div>

    <!-- Controls and Mitigation -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Kawalan Sediada</h2>
            <div class="text-gray-700 whitespace-pre-wrap">
                {{ $risk->kawalan_sediada ?? 'Tiada maklumat' }}
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Pelan Mitigasi</h2>
            <div class="text-gray-700 whitespace-pre-wrap">
                {{ $risk->plan_mitigasi ?? 'Tiada maklumat' }}
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-6">
        <p class="text-sm text-blue-800">
            <strong>Nota:</strong> Risiko ini telah didaftarkan pada {{ $risk->created_at->format('d/m/Y') }} dan terakhir dikemaskini pada {{ $risk->updated_at->format('d/m/Y') }}.
        </p>
    </div>
</div>
@endsection
