<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pengurusan Risiko Quantum')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navigation -->
    {{-- <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50"> --}}
    <nav class="bg-white shadow-md flex-none">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">

                <button id="toggleSidebar" class="text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                @auth
                    <a href="{{ route(Auth::user()->role . '.dashboard') }}"
                        class="flex items-center hover:opacity-80 transition">
                        <h1 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-shield-alt text-blue-600 ml-3 mr-2"></i>
                            Risiko Quantum
                        </h1>
                    </a>
                @else
                    <h1 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-shield-alt text-blue-600 ml-3 mr-2"></i>
                        Risiko Quantum
                    </h1>
                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-circle text-gray-600"></i>
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="flex flex-1">
        <!-- Sidebar and Main Content -->
        <div id="sidebar"
            class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white transform -translate-x-full transition-transform duration-300">
            @auth
                <!-- Sidebar -->
                <aside class="w-64 bg-gray-800 text-gray-100 min-h-screen flex flex-col mt-5">
                    {{-- logo atas side bar --}}
                    <i class="fas fa-shield-alt text-blue-600 text-4xl ml-auto mr-auto"></i>
                    <div class="p-6">
                        @if (Auth::user()->role === 'admin')
                            <!-- Admin Menu -->
                            <ul class="space-y-4">
                                <li><a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a></li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.risks.index') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-exclamation-triangle"></i> Senarai Risiko
                                    </a>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.users.index') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-users"></i> Pengurusan Pengguna
                                    </a>
                                </li>

                                <!-- Data Management Section -->
                                <li class="pt-2 mt-2 border-t border-gray-600">
                                    <div class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-2">
                                        Pengurusan
                                        Data</div>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.data.asset-types') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-sm">
                                        <i class="fas fa-cog"></i> Jenis Aset
                                    </a>
                                </li>

                                <!-- Risk Categories Hierarchy -->
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.data.risk-categories') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-sm font-semibold text-gray-300">
                                        <i class="fas fa-list"></i> Kategori Risiko
                                    </a>
                                </li>
                                <li class="pl-6 border-l-2 border-gray-500">
                                    <a href="{{ route('admin.data.sub-categories') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-xs">
                                        ├─ Sub-Kategori
                                    </a>
                                </li>
                                <li class="pl-6 border-l-2 border-gray-500">
                                    <a href="{{ route('admin.data.risks') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-xs">
                                        ├─ Risiko
                                    </a>
                                </li>
                                <li class="pl-6 border-l-2 border-gray-500">
                                    <a href="{{ route('admin.data.causes') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-xs">
                                        └─ Punca Risiko
                                    </a>
                                </li>

                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.data.agencies') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-sm">
                                        <i class="fas fa-building"></i> Agensi
                                    </a>
                                </li>

                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.data.sectors') }}"
                                        class="flex items-center gap-2 hover:text-blue-400 text-sm">
                                        <i class="fas fa-cubes"></i> Sektor
                                    </a>
                                </li>

                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('admin.reports.index') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-file-alt"></i> Laporan
                                    </a>
                                </li>
                            </ul>
                        @elseif (Auth::user()->role === 'agency')
                            <!-- Agency Menu -->
                            <ul class="space-y-4">
                                <li><a href="{{ route('agency.dashboard') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a></li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('agency.risks.index') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-exclamation-triangle"></i> Senarai Risiko
                                    </a>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('agency.risks.create') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-plus"></i> Daftar Risiko
                                    </a>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('agency.data.assets') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-database"></i> Pengurusan Aset
                                    </a>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('agency.data.agencies') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-building"></i> Pengurusan Agensi
                                    </a>
                                </li>
                                <li class="pl-4 border-l border-gray-600">
                                    <a href="{{ route('agency.reports.index') }}"
                                        class="flex items-center gap-2 hover:text-blue-400">
                                        <i class="fas fa-file-alt"></i> Laporan
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </aside>
            @endauth


        </div>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-100 text-center py-4 flex-none">
        <p>&copy; 2026 Sistem Pengurusan Risiko Quantum. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            if (!toggleBtn || !sidebar) return;

            // TOGGLE FUNCTION
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
            }

            // BUTTON CLICK (OPEN & CLOSE)
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // prevent document click
                toggleSidebar();
            });

            // CLICK OUTSIDE (mobile + desktop)
            document.addEventListener('click', function(e) {
                const isClickInsideSidebar = sidebar.contains(e.target);
                const isClickToggleBtn = toggleBtn.contains(e.target);

                // jika klik bukan dalam sidebar dan bukan button → tutup
                if (!sidebar.classList.contains('-translate-x-full') && !isClickInsideSidebar && !
                    isClickToggleBtn) {
                    closeSidebar();
                }
            });

            // CLICK LINK → CLOSE (mobile saja)
            const links = sidebar.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });

            // PREVENT CLICK DALAM SIDEBAR BUBBLING
            sidebar.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // RESIZE FIX
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });

        });
    </script>
</body>

</html>
