<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Pengurusan Risiko Quantum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen flex items-center justify-center py-12">
    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="inline-block p-3 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Risiko Quantum</h1>
                <p class="text-gray-600 text-sm mt-2">Daftar Akaun Baru</p>
            </div>

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}"
                        placeholder="Nama anda"
                        required
                    >
                    @error('name')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>Emel
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                        placeholder="nama@contoh.com"
                        required
                    >
                    @error('email')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Kata Laluan
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Sahkan Kata Laluan
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <!-- Role Selection -->
                <div class="mb-6">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user-tie mr-2"></i>Peranan
                    </label>
                    <select 
                        name="role" 
                        id="role" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                        required
                        onchange="toggleSectorAgencyFields()"
                    >
                        <option value="">Pilih Peranan</option>
                        {{-- <option value="admin" @selected(old('role') === 'admin')>Admin</option> --}}
                        <option value="agency" @selected(old('role') === 'agency')>Agensi</option>
                    </select>
                    @error('role')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sector Field (for agency users) -->
                <div class="mb-6" id="sectorField" style="display: none;">
                    <label for="sektor_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-layer-group mr-2"></i>Sektor
                    </label>
                    <select 
                        name="sektor_id" 
                        id="sektor_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="loadAgencies()"
                    >
                        <option value="">Pilih Sektor</option>
                        @foreach($sektors as $sektor)
                            <option value="{{ $sektor->id }}" @selected(old('sektor_id') === (string)$sektor->id)>{{ $sektor->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Agency Field (for agency users) -->
                <div class="mb-6" id="agencyField" style="display: none;">
                    <label for="agensi_id" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-building mr-2"></i>Agensi
                    </label>
                    <select 
                        name="agensi_id" 
                        id="agensi_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('agensi_id') border-red-500 @enderror"
                    >
                        <option value="">Pilih Agensi</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" @selected(old('agensi_id') === (string)$agency->id)>{{ $agency->nama_agensi }}</option>
                        @endforeach
                    </select>
                    @error('agensi_id')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                >
                    <i class="fas fa-user-plus mr-2"></i>Daftar
                </button>
            </form>

            <!-- Divider -->
            <div class="relative mt-6 mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-600">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <p class="text-center text-gray-700">
                Sudah ada akaun?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>

    <script>
        // Store all agencies with their sectors
        const allAgencies = {
            @foreach($agencies as $agency)
                {{ $agency->id }}: { nama: '{{ $agency->nama_agensi }}', sektor_id: {{ $agency->sektor_id }} },
            @endforeach
        };

        function toggleSectorAgencyFields() {
            const role = document.getElementById('role').value;
            const sectorField = document.getElementById('sectorField');
            const agencyField = document.getElementById('agencyField');
            
            if (role === 'agency') {
                sectorField.style.display = 'block';
                agencyField.style.display = 'block';
                document.getElementById('sektor_id').required = true;
                document.getElementById('agensi_id').required = true;
            } else {
                sectorField.style.display = 'none';
                agencyField.style.display = 'none';
                document.getElementById('sektor_id').required = false;
                document.getElementById('agensi_id').required = false;
                document.getElementById('agensi_id').value = '';
            }
        }

        function loadAgencies() {
            const sektorId = document.getElementById('sektor_id').value;
            const agencySelect = document.getElementById('agensi_id');
            const selectedAgency = agencySelect.value;
            
            agencySelect.innerHTML = '<option value="">Pilih Agensi</option>';
            
            // Filter agencies by selected sector
            for (const [agencyId, agency] of Object.entries(allAgencies)) {
                if (parseInt(agency.sektor_id) === parseInt(sektorId)) {
                    const option = document.createElement('option');
                    option.value = agencyId;
                    option.textContent = agency.nama;
                    if (selectedAgency == agencyId) {
                        option.selected = true;
                    }
                    agencySelect.appendChild(option);
                }
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSectorAgencyFields();
            
            // If there's a saved sektor_id, load agencies for it
            const sektorId = document.getElementById('sektor_id').value;
            if (sektorId) {
                loadAgencies();
            }
        });
    </script>
</body>
</html>
