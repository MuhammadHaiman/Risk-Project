@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Senarai Agensi dalam Sektor Anda</h1>
            <a href="{{ route('agency.data.create-agency') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Agensi
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nama Agensi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">No. Telefon</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Emel PIC</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agencies as $agency)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $agency->id }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">
                                <strong>{{ $agency->nama_agensi }}</strong>
                                @if (auth()->user()->agensi_id == $agency->id)
                                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Agensi
                                        Saya</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $agency->no_tel_agensi }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $agency->emel_pic }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $agency->jenis_agensi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-gray-500">Tiada agensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $agencies->links() }}
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4">
            <h4 class="font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Maklumat
            </h4>
            <ul class="text-blue-700 text-sm space-y-1">
                <li>• Anda hanya boleh melihat agensi-agensi dalam sektor yang sama</li>
                <li>• Anda boleh menambah agensi baru dalam sektor anda</li>
                <li>• Hanya admin yang boleh memadam agensi</li>
            </ul>
        </div>
    </div>
@endsection
