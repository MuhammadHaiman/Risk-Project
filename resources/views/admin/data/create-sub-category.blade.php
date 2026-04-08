@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.data.sub-categories') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Sub-Kategori Risiko</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-2xl">
            <form action="{{ route('admin.data.store-sub-category') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="kategori_risiko_id" class="block text-gray-700 font-semibold mb-2">Kategori Induk</label>
                    <select name="kategori_risiko_id" id="kategori_risiko_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Pilih Kategori</option>
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
                    <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Sub-Kategori</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Gangguan Operasi, Ancaman Dalaman" required value="{{ old('nama') }}">
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('admin.data.sub-categories') }}"
                        class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
