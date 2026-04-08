@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.data.agencies') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Agensi Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-4xl">
            <form action="{{ route('admin.data.store-agency') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Agensi -->
                    <div>
                        <label for="nama_agensi" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-building mr-2"></i>Nama Agensi <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="nama_agensi" id="nama_agensi"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_agensi') border-red-500 @enderror"
                            value="{{ old('nama_agensi') }}" placeholder="Nama Agensi" required>
                        @error('nama_agensi')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Sektor -->
                    <div>
                        <label for="sektor_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-list mr-2"></i>Sektor <span class="text-red-600">*</span>
                        </label>
                        <select name="sektor_id" id="sektor_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sektor_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Sektor --</option>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('sektor_id') == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('sektor_id')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Agensi -->
                    <div>
                        <label for="jenis_agensi" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-tag mr-2"></i>Jenis Agensi <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="jenis_agensi" id="jenis_agensi"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_agensi') border-red-500 @enderror"
                            value="{{ old('jenis_agensi') }}" placeholder="e.g., Kerajaan, Swasta, Badan Berkanun" required>
                        @error('jenis_agensi')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No. Telefon Agensi -->
                    <div>
                        <label for="no_tel_agensi" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone mr-2"></i>No. Telefon Agensi <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="no_tel_agensi" id="no_tel_agensi"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_tel_agensi') border-red-500 @enderror"
                            value="{{ old('no_tel_agensi') }}" placeholder="e.g., 0312345678" required>
                        @error('no_tel_agensi')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-globe mr-2"></i>Laman Web
                        </label>
                        <input type="text" name="website" id="website"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('website') border-red-500 @enderror"
                            value="{{ old('website') }}" placeholder="https://www.agensi.gov.my">
                        @error('website')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nama PIC -->
                    <div>
                        <label for="nama_pic" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-2"></i>Nama PIC <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="nama_pic" id="nama_pic"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_pic') border-red-500 @enderror"
                            value="{{ old('nama_pic') }}" placeholder="Nama Pegawai Perhubungan" required>
                        @error('nama_pic')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- No. Telefon PIC -->
                    <div>
                        <label for="notel_pic" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-mobile-alt mr-2"></i>No. Telefon PIC <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="notel_pic" id="notel_pic"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notel_pic') border-red-500 @enderror"
                            value="{{ old('notel_pic') }}" placeholder="e.g., 0198765432" required>
                        @error('notel_pic')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Emel PIC -->
                    <div>
                        <label for="emel_pic" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2"></i>Emel PIC <span class="text-red-600">*</span>
                        </label>
                        <input type="email" name="emel_pic" id="emel_pic"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('emel_pic') border-red-500 @enderror"
                            value="{{ old('emel_pic') }}" placeholder="pic@agensi.gov.my" required>
                        @error('emel_pic')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.data.agencies') }}"
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
                    <li>• Semua medan yang ditandai dengan * adalah wajib diisi</li>
                    <li>• PIC adalah Pegawai Perhubungan Agensi</li>
                    <li>• Pastikan semua maklumat adalah terkini dan tepat</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
