@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Agensi</h1>
        <p class="text-gray-600">{{ $agency->nama_agensi }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Tahap Risiko Tinggi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $highRisks }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Risk Distribution -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Tinggi</h3>
            <p class="text-4xl font-bold text-red-600">{{ $highRisks }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Sederhana</h3>
            <p class="text-4xl font-bold text-yellow-600">{{ $mediumRisks }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Risiko Rendah</h3>
            <p class="text-4xl font-bold text-green-600">{{ $lowRisks }}</p>
        </div>
    </div>

    <!-- Risk Level Charts -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pie Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengedaran Tahap Risiko (Carta Pai)</h3>
            <div class="flex justify-center">
                <div class="w-full max-w-sm">
                    <canvas id="riskChartAgency"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Pengedaran Tahap Risiko (Carta Bar)</h3>
            <div class="flex justify-center">
                <div class="w-full">
                    <canvas id="riskBarChartAgency"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart
            const pieCtx = document.getElementById('riskChartAgency').getContext('2d');
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
            const barCtx = document.getElementById('riskBarChartAgency').getContext('2d');
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
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kunci Pintas</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <a href="{{ route('agency.risks.index') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Senarai Risiko</p>
            </a>
            <a href="{{ route('agency.risks.create') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Daftar Risiko</p>
            </a>
            <a href="{{ route('agency.data.assets') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Pengurusan Aset</p>
            </a>
            <a href="{{ route('agency.reports.index') }}" class="block text-center p-4 border border-gray-200 rounded hover:bg-blue-50">
                <p class="font-semibold text-gray-800">Laporan</p>
            </a>
        </div>
    </div>
</div>
@endsection
