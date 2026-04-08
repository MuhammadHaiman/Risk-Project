@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Aset dengan Bilangan Risiko Tertinggi</h1>
            <a href="{{ route(Auth::user()->role . '.dashboard') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Report Navigation Tabs -->
        <div class="mb-6 bg-white rounded-lg shadow">
            <div class="flex flex-wrap border-b">
                <a href="{{ route('agency.reports.index') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-gray-200 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-list mr-2"></i> Semua Risiko
                </a>
                <a href="{{ route('agency.reports.highest-risk') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-gray-200 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-chart-line mr-2"></i> Risiko Tertinggi
                </a>
                <a href="{{ route('agency.reports.asset-highest-risks') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-blue-600 text-blue-600 font-semibold">
                    <i class="fas fa-cubes mr-2"></i> Aset Risiko Tertinggi
                </a>
            </div>
        </div>

        <!-- Export Buttons -->
        <div class="mb-6 bg-white rounded-lg shadow p-6">
            <div class="flex gap-2">
                <a href="{{ route('agency.reports.asset-highest-risks-pdf') }}"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('agency.reports.asset-highest-risks-excel') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 flex items-center gap-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <div class="p-6">
                <p class="text-gray-700 mb-4">
                    <strong>Laporan ini menunjukkan aset yang mempunyai bilangan risiko terdaftar paling tinggi dalam agensi
                        anda.</strong>
                </p>
            </div>

            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Kedudukan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nama Aset</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Jenis Aset</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Bilangan Risiko Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assetRiskCounts as $index => $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full font-bold">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-700 font-semibold">{{ $item->asset->nama_aset }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $item->asset->jenisAset->nama ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-sm">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">
                                    {{ $item->risk_count }} risiko
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-600">Tiada data aset tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $assetRiskCounts->links() }}
        </div>
    </div>
@endsection
