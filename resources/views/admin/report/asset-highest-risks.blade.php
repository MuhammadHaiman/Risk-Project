@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Aset dengan Bilangan Risiko Tertinggi Mengikut Agensi</h1>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Filter Section -->
        <div class="mb-6 bg-white rounded-lg shadow p-6">
            <form method="GET" action="{{ route('admin.reports.asset-highest-risks') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="sector" class="block text-sm font-semibold text-gray-700 mb-2">Tapis Mengikut
                        Sektor:</label>
                    <select name="sector" id="sector"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">-- Semua Sektor --</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}" @if ($selectedSector == $sector->id) selected @endif>
                                {{ $sector->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="agency" class="block text-sm font-semibold text-gray-700 mb-2">Tapis Mengikut
                        Agensi:</label>
                    <select name="agency" id="agency"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="">-- Semua Agensi --</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}" @if ($selectedAgency == $agency->id) selected @endif>
                                {{ $agency->nama_agensi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 col-span-1 md:col-span-2">
                    <button type="submit"
                        class="flex-1 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i> Tapis
                    </button>
                    @if ($selectedSector || $selectedAgency)
                        <a href="{{ route('admin.reports.asset-highest-risks') }}"
                            class="flex-1 px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i> Padam
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Export Buttons -->
        <div class="mb-6 bg-white rounded-lg shadow p-6">
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.asset-highest-risks-pdf') }}?{{ request()->getQueryString() }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('admin.reports.asset-highest-risks-excel') }}?{{ request()->getQueryString() }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>

        <!-- Reports by Agency -->
        @forelse ($assetRisksByAgency as $agencyId => $data)
            <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">{{ $data['agency']->nama_agensi }}</h2>
                    <p class="text-green-100 text-sm">{{ $data['agency']->sektor->nama ?? 'N/A' }} | Telefon:
                        {{ $data['agency']->no_tel_agensi }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Kedudukan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nama Aset</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Jenis Aset</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Bilangan Risiko</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data['assets'] as $index => $asset)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-sm font-semibold text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-700">{{ $asset->asset->nama_aset ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-700">
                                        {{ $asset->asset->jenisAset->nama ?? 'N/A' }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-700">
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">{{ $asset->risk_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tiada aset dengan risiko
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-600 text-lg">Tiada data laporan untuk filter yang dipilih</p>
            </div>
        @endforelse
    </div>
@endsection
