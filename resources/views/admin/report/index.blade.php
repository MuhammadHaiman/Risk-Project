@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Laporan Risiko</h1>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Report Navigation Tabs -->
        <div class="mb-6 bg-white rounded-lg shadow">
            <div class="flex flex-wrap border-b">
                <a href="{{ route('admin.reports.index') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-blue-600 text-blue-600 font-semibold">
                    <i class="fas fa-list mr-2"></i> Semua Risiko
                </a>
                <a href="{{ route('admin.reports.highest-risk') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-gray-200 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-chart-line mr-2"></i> Risiko Tertinggi
                </a>
                <a href="{{ route('admin.reports.asset-highest-risks') }}"
                    class="flex-1 px-4 py-4 text-center border-b-4 border-gray-200 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-cubes mr-2"></i> Aset Risiko Tertinggi
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Agensi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Aset</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Risiko</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tahap</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Skor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($risks as $risk)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $risk->id }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $risk->agency->nama_agensi }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $risk->asset->nama_aset }}</td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $risk->risiko->nama ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-sm">
                                @if ($risk->tahap_risiko === 'Tinggi')
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Tinggi</span>
                                @elseif ($risk->tahap_risiko === 'Sederhana')
                                    <span
                                        class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Sederhana</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Rendah</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm font-semibold">{{ $risk->skor_risiko }}</td>
                            <td class="px-6 py-3 text-sm">
                                <a href="{{ route('admin.risks.show', $risk->id) }}"
                                    class="text-blue-600 hover:text-blue-800">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $risks->links() }}
        </div>
    </div>
@endsection
