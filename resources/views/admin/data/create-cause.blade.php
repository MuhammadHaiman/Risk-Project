@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.data.causes') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Punca Risiko</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
            <form action="{{ route('admin.data.store-cause') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="kategori_risiko_id" class="block text-gray-700 font-semibold mb-2">Kategori Risiko</label>
                    <select name="kategori_risiko_id" id="kategori_risiko_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Pilih Kategori Risiko</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('kategori_risiko_id') == $category->id)>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_risiko_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Punca Risiko</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Cakera Keras Gagal, Penggodam Berpengalaman" required
                        value="{{ old('nama') }}">
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('admin.data.causes') }}"
                        class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </form>

            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded p-4">
                <h3 class="font-semibold text-blue-900 mb-2"><i class="fas fa-info-circle mr-2"></i> Panduan</h3>
                <p class="text-blue-800 text-sm mb-2">Punca risiko adalah faktor penyebab terjadinya risiko dalam kategori
                    tertentu.</p>
                <ul class="text-blue-800 text-sm space-y-1">
                    <li>• Pilih kategori risiko yang sesuai terlebih dahulu</li>
                    <li>• Contoh untuk Keamanan Siber: "Penggodam Berpengalaman", "Malware Terinfeksi"</li>
                    <li>• Contoh untuk Operasional: "Cakera Keras Gagal", "Sambungan Rangkaian Terputus"</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
