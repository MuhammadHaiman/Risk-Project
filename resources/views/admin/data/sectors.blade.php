@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Sektor</h1>
            <a href="{{ route('admin.data.create-sector') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Sektor
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Jumlah Agensi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sectors as $sector)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $sector->id }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $sector->nama }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $sector->agencies_count }}</td>
                            <td class="px-6 py-3 text-sm">
                                <button type="button"
                                    onclick="if(confirm('Adakah anda pasti ingin memadam sektor ini? Sektor ini hanya boleh dipadam jika tiada agensi yang berkaitan.')) { document.getElementById('delete-form-{{ $sector->id }}').submit(); }"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i> Padam
                                </button>
                                <form id="delete-form-{{ $sector->id }}"
                                    action="{{ route('admin.data.destroy-sector', $sector->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center text-gray-500">Tiada sektor</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sectors->links() }}
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4">
            <h4 class="font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Maklumat
            </h4>
            <ul class="text-blue-700 text-sm space-y-1">
                <li>• Ketika menambah sektor baru, anda mempunyai pilihan untuk menambah agensi dengan serta-merta</li>
                <li>• Sektor hanya boleh dipadam jika tiada agensi yang berkaitan</li>
                <li>• Hanya admin yang boleh memadam sektor</li>
            </ul>
        </div>
    </div>
@endsection
