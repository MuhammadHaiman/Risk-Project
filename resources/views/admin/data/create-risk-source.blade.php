@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Kategori Punca Risiko</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.data.store-risk-source') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border border-gray-300 rounded" 
                    placeholder="Contoh: Peralatan Rosak, Kesalahan Manusia, Penyerang Berbakat" required value="{{ old('nama') }}">
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.data.risk-sources') }}" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-4">
            <h3 class="font-semibold text-blue-900 mb-2">Panduan</h3>
            <ul class="text-blue-800 text-sm space-y-1">
                <li>• Ini adalah kategori induk untuk punca risiko spesifik</li>
                <li>• Contoh: Peralatan Rosak, Kesalahan Manusia, Sistem Lapuk, dsb.</li>
                <li>• Setiap kategori boleh mempunyai banyak punca risiko terperinci</li>
            </ul>
        </div>
    </div>
</div>
@endsection
