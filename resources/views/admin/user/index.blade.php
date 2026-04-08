@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pengurusan Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Pengguna
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            {{ $message }}
        </div>
    @endif

    <!-- Sector Filter -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4 items-end">
            <div class="flex-1">
                <label for="sektor_id" class="block text-sm font-semibold text-gray-700 mb-2">Filter Mengikut Sektor</label>
                <select name="sektor_id" id="sektor_id" class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Sektor</option>
                    @foreach ($sektors as $sektor)
                        <option value="{{ $sektor->id }}" {{ $selectedSektor == $sektor->id ? 'selected' : '' }}>{{ $sektor->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-filter mr-2"></i>Tapis
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                <i class="fas fa-redo mr-2"></i>Set Semula
            </a>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Peranan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Agensi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $user->id }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $user->name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="px-3 py-1 @if($user->role === 'admin') bg-red-100 text-red-800 @else bg-blue-100 text-blue-800 @endif rounded-full text-xs font-semibold">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        @if($user->agency)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $user->agency->nama_agensi }}</span>
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-green-600 hover:text-green-800 mr-2">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Pasti?')">Padam</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
