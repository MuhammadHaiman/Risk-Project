@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.data.sectors') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Sektor Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-8 max-w-4xl">
            <form action="{{ route('admin.data.store-sector') }}" method="POST">
                @csrf

                <!-- Sektor Section -->
                <div class="mb-8 pb-8 border-b">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-cubes mr-2 text-blue-600"></i>Maklumat Sektor
                    </h2>

                    <div class="mb-6">
                        <label for="nama" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-tag mr-2"></i>Nama Sektor <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="nama" id="nama"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                            value="{{ old('nama') }}" placeholder="e.g., Kesihatan, Pendidikan, Pertanian" required>
                        @error('nama')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Agency Checkbox & Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-building mr-2 text-green-600"></i>Agensi (Pilihan)
                    </h2>

                    <label class="flex items-center gap-3 mb-6 cursor-pointer">
                        <input type="checkbox" id="create_agency" name="create_agency" value="1"
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="text-gray-700 font-medium">Tambah Agensi ke Sektor Ini Sekarang Juga</span>
                    </label>

                    <!-- Agency Form (Hidden by default) -->
                    <div id="agencyForm" class="hidden bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Agensi -->
                            <div>
                                <label for="nama_agensi" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-building mr-2"></i>Nama Agensi
                                </label>
                                <input type="text" name="nama_agensi" id="nama_agensi"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('nama_agensi') }}" placeholder="Nama Agensi">
                                @error('nama_agensi')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Agensi -->
                            <div>
                                <label for="jenis_agensi" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-tag mr-2"></i>Jenis Agensi
                                </label>
                                <input type="text" name="jenis_agensi" id="jenis_agensi"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('jenis_agensi') }}" placeholder="e.g., Kerajaan, Swasta, Badan Berkanun">
                                @error('jenis_agensi')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- No. Telefon Agensi -->
                            <div>
                                <label for="no_tel_agensi" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-phone mr-2"></i>No. Telefon Agensi
                                </label>
                                <input type="text" name="no_tel_agensi" id="no_tel_agensi"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('no_tel_agensi') }}" placeholder="e.g., 0312345678">
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('website') }}" placeholder="https://www.agensi.gov.my">
                                @error('website')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama PIC -->
                            <div>
                                <label for="nama_pic" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-user mr-2"></i>Nama PIC
                                </label>
                                <input type="text" name="nama_pic" id="nama_pic"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('nama_pic') }}" placeholder="Nama Pegawai Perhubungan">
                                @error('nama_pic')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- No. Telefon PIC -->
                            <div>
                                <label for="notel_pic" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-mobile-alt mr-2"></i>No. Telefon PIC
                                </label>
                                <input type="text" name="notel_pic" id="notel_pic"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('notel_pic') }}" placeholder="e.g., 0198765432">
                                @error('notel_pic')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Emel PIC -->
                            <div class="md:col-span-2">
                                <label for="emel_pic" class="block text-gray-700 font-semibold mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Emel PIC
                                </label>
                                <input type="email" name="emel_pic" id="emel_pic"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('emel_pic') }}" placeholder="pic@agensi.gov.my">
                                @error('emel_pic')
                                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.data.sectors') }}"
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
                    <li>• Nama sektor mesti unik dalam sistem</li>
                    <li>• Anda boleh memilih untuk menambah agensi sekarang atau kemudian</li>
                    <li>• Setiap sektor boleh mempunyai banyak agensi</li>
                </ul>
            </div>
        </div>

        <script>
            const createAgencyCheckbox = document.getElementById('create_agency');
            const agencyForm = document.getElementById('agencyForm');

            createAgencyCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    agencyForm.classList.remove('hidden');
                } else {
                    agencyForm.classList.add('hidden');
                }
            });

            // Show form if checkbox was checked before (on page reload due to validation error)
            if (createAgencyCheckbox.checked) {
                agencyForm.classList.remove('hidden');
            }
        </script>
    </div>
@endsection
