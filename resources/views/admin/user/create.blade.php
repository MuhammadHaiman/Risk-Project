@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pengguna</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500">
            <ul class="text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('email') }}" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Laluan</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Peranan</label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent" required onchange="toggleAgencyField()">
                    <option value="">Pilih Peranan</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="agency" {{ old('role') === 'agency' ? 'selected' : '' }}>Agensi</option>
                </select>
            </div>

            <div class="mb-4" id="agencyField" style="display: none;">
                <label for="agensi_id" class="block text-sm font-semibold text-gray-700 mb-2">Agensi</label>
                <select name="agensi_id" id="agensi_id" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Pilih Agensi (Opsyenal untuk Admin)</option>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ old('agensi_id') == $agency->id ? 'selected' : '' }}>{{ $agency->nama_agensi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAgencyField() {
    const role = document.getElementById('role').value;
    const agencyField = document.getElementById('agencyField');
    if (role === 'agency') {
        agencyField.style.display = 'block';
        document.getElementById('agensi_id').required = true;
    } else {
        agencyField.style.display = 'none';
        document.getElementById('agensi_id').required = false;
    }
}

// Run on page load to set initial state
document.addEventListener('DOMContentLoaded', toggleAgencyField);
</script>
@endsection
