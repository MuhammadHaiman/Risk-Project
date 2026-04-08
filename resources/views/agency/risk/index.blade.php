@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Senarai Risiko Agensi</h1>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                {{ $message }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Aset</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Risiko</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tahap</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Skor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($risks as $risk)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $risk->id }}</td>
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
                                <a href="{{ route('agency.risks.show', $risk->id) }}"
                                    class="text-blue-600 hover:text-blue-800 mr-2">Lihat</a>
                                {{-- <a href="{{ route('agency.risks.edit', $risk->id) }}"
                                    class="text-green-600 hover:text-green-800">Edit</a> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">Tiada risiko didaftarkan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $risks->links() }}
        </div>
    </div>
@endsection
