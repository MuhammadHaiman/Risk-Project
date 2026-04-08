@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kategori Punca Risiko</h1>
        <a href="{{ route('admin.data.create-risk-source') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Nama Kategori</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Punca Risiko</th>
                    <th class="px-6 py-3 text-center text-gray-700 font-semibold">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sources as $source)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700">{{ $source->id }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $source->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $source->punca_risikos_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.data.destroy-risk-source', $source->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Adakah anda pasti?')">
                                    <i class="fas fa-trash"></i> Padam
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tiada kategori punca risiko</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sources->links() }}
    </div>
</div>
@endsection
