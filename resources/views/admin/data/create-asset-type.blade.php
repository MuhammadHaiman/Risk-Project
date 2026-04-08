@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.data.asset-types') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Jenis Aset Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
            <form action="{{ route('admin.data.store-asset-type') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-tag mr-2"></i>Nama Jenis Aset <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama') }}" placeholder="e.g., Server, Komputer Meja, Laptop" required>
                    @error('nama')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="text-gray-600 text-sm mt-2">Masukkan nama kategori aset yang unik</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.data.asset-types') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4">
                <h4 class="font-semibold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-2"></i>Maklumat
                </h4>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li>• Nama jenis aset mesti unik dalam sistem</li>
                    <li>• Berikan nama yang deskriptif dan mudah difahami</li>
                    <li>• Contoh: Server, Komputer Meja, Laptop, iPad, Router</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
