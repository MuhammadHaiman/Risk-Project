@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Jenis Aset</h1>
        <a href="{{ route('admin.data.create-asset-type') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Jenis Aset
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            {{ $message }}
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            {{ $message }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Jumlah Aset</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assets as $asset)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $asset->id }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $asset->nama }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            {{ $asset->assets_count }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm">
                        <form action="{{ route('admin.data.destroy-asset-type', $asset->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Pasti ingin padam?')">
                                <i class="fas fa-trash mr-2"></i>Padam
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-3 text-center text-gray-500">Tiada jenis aset</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
    </div>
</div>
@endsection
