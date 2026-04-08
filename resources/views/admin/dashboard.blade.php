@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang ke Sistem Pengurusan Risiko Quantum</p>
    </div>

    <!-- Sector Filter -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-4 items-end">
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
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                <i class="fas fa-redo mr-2"></i>Set Semula
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292m0 0H8.646M12 9.354v4.292m3.854-1.938a4 4 0 11-5.292-5.292m1.636 5.292H16"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Jumlah Agensi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAgencies }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10m0-10L4 7m16 0L8 11m8-4v10m0-10l-8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Jumlah Aset</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalAssets }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Jumlah Risiko</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalRisks }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292m0 0H8.646M12 9.354v4.292m3.854-1.938a4 4 0 11-5.292-5.292m1.636 5.292H16"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Jumlah Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Risk Level Distribution -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Tinggi</h3>
            <p class="text-4xl font-bold text-red-600">{{ $highRisks }}</p>
            <p class="text-gray-600 text-sm mt-2">Risiko yang memerlukan tindakan segera</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Sederhana</h3>
            <p class="text-4xl font-bold text-yellow-600">{{ $mediumRisks }}</p>
            <p class="text-gray-600 text-sm mt-2">Risiko yang memerlukan perhatian</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Rendah</h3>
            <p class="text-4xl font-bold text-green-600">{{ $lowRisks }}</p>
            <p class="text-gray-600 text-sm mt-2">Risiko yang dapat dipantau</p>
        </div>
    </div>

    <!-- Risk Level Charts -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pie Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengedaran Tahap Risiko (Carta Pai)</h3>
            <div class="flex justify-center">
                <div class="w-full max-w-sm">
                    <canvas id="riskChartAdmin"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengedaran Tahap Risiko (Carta Bar)</h3>
            <div class="flex justify-center">
                <div class="w-full">
                    <canvas id="riskBarChartAdmin"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart
            const pieCtx = document.getElementById('riskChartAdmin').getContext('2d');
            const riskChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Tinggi', 'Sederhana', 'Rendah'],
                    datasets: [{
                        data: [{{ $highRisks }}, {{ $mediumRisks }}, {{ $lowRisks }}],
                        backgroundColor: ['#ef4444', '#eab308', '#22c55e'],
                        borderColor: ['#dc2626', '#ca8a04', '#16a34a'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

            // Bar Chart
            const barCtx = document.getElementById('riskBarChartAdmin').getContext('2d');
            const barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Tinggi', 'Sederhana', 'Rendah'],
                    datasets: [{
                        label: 'Bilangan Risiko',
                        data: [{{ $highRisks }}, {{ $mediumRisks }}, {{ $lowRisks }}],
                        backgroundColor: ['#ef4444', '#eab308', '#22c55e'],
                        borderColor: ['#dc2626', '#ca8a04', '#16a34a'],
                        borderWidth: 2,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Quick Links -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kunci Pintas</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.risks.index') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Pengurusan Risiko</p>
            </a>
            <a href="{{ route('admin.users.index') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Pengurusan Pengguna</p>
            </a>
            <a href="{{ route('admin.data.agencies') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Pengurusan Data</p>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Laporan</p>
            </a>
        </div>
    </div>
</div>
@endsection
