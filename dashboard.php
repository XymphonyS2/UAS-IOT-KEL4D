<?php
require_once 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CHICKMON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="LITZPUTIH.png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-gradient { background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%); }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .sensor-card { transition: all 0.3s ease; }
        .sensor-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .status-indicator { width: 12px; height: 12px; border-radius: 50%; }
        .status-on { background: #22c55e; box-shadow: 0 0 10px #22c55e; }
        .status-off { background: #ef4444; box-shadow: 0 0 10px #ef4444; }
        .pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .nav-item { transition: all 0.2s ease; }
        .nav-item:hover { background: rgba(255,255,255,0.1); }
        .nav-item.active { background: rgba(255,255,255,0.2); border-right: 3px solid white; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 sidebar-gradient text-white flex flex-col flex-shrink-0">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">CHICKMON</h1>
                        <p class="text-xs text-white/60">Smart Monitoring</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 py-6">
                <ul class="space-y-1 px-3">
                    <li>
                        <a href="dashboard.php" class="nav-item active flex items-center gap-3 px-4 py-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="grafik.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-white/70 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="font-medium">Grafik</span>
                        </a>
                    </li>
                    <li>
                        <a href="kontrol.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-white/70 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Kontrol Manual</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-sm"><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username']); ?></p>
                        <p class="text-xs text-white/60">Administrator</p>
                    </div>
                </div>
                <a href="logout.php" class="flex items-center justify-center gap-2 w-full py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </a>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                        <p class="text-sm text-gray-500">Monitoring sensor dan status komponen</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-500 rounded-full pulse"></div>
                            <span>Live Update</span>
                        </div>
                        <div id="lastUpdate" class="text-sm text-gray-500">--:--:--</div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="sensor-card bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span id="statusSuhu" class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">--</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-1">Suhu</p>
                        <p class="text-3xl font-bold text-gray-800"><span id="suhuValue">--</span><span class="text-lg text-gray-400">°C</span></p>
                    </div>

                    <div class="sensor-card bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-600">Humidity</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-1">Kelembapan</p>
                        <p class="text-3xl font-bold text-gray-800"><span id="kelembapanValue">--</span><span class="text-lg text-gray-400">%</span></p>
                    </div>

                    <div class="sensor-card bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <span id="statusGas" class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">--</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-1">Gas Amonia</p>
                        <p class="text-3xl font-bold text-gray-800"><span id="gasValue">--</span><span class="text-lg text-gray-400"> ppm</span></p>
                    </div>

                    <div class="sensor-card bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span id="statusCahaya" class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">--</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-1">Cahaya</p>
                        <p class="text-3xl font-bold text-gray-800"><span id="cahayaValue">--</span><span class="text-lg text-gray-400"> lux</span></p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Komponen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Kipas Masuk</p>
                                    <p class="text-sm text-gray-500">Intake Fan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="kipasmasukIndicator" class="status-indicator status-off"></div>
                                    <span id="kipasmasukStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span id="kipasmasukMode" class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">AUTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Kipas Keluar</p>
                                    <p class="text-sm text-gray-500">Exhaust Fan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="kipasKeluarIndicator" class="status-indicator status-off"></div>
                                    <span id="kipasKeluarStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span id="kipasKeluarMode" class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">AUTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Lampu Penghangat</p>
                                    <p class="text-sm text-gray-500">Heater Lamp</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="lampuHangatIndicator" class="status-indicator status-off"></div>
                                    <span id="lampuHangatStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span id="lampuHangatMode" class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">AUTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Lampu Penerangan</p>
                                    <p class="text-sm text-gray-500">Lighting</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="lampuTerangIndicator" class="status-indicator status-off"></div>
                                    <span id="lampuTerangStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span id="lampuTerangMode" class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">AUTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Conveyor</p>
                                    <p class="text-sm text-gray-500">Belt System</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="conveyorIndicator" class="status-indicator status-off"></div>
                                    <span id="conveyorStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span id="conveyorMode" class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">AUTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Buzzer</p>
                                    <p class="text-sm text-gray-500">Alarm</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-2 mb-1">
                                    <div id="buzzerIndicator" class="status-indicator status-off"></div>
                                    <span id="buzzerStatus" class="font-medium text-gray-600">MATI</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">LINKED</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function fetchData() {
            fetch('api/get_sensor_data.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateSensorDisplay(data);
                        updateComponentDisplay(data);
                        document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('id-ID');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateSensorDisplay(data) {
            if (data.sensor) {
                document.getElementById('suhuValue').textContent = parseFloat(data.sensor.suhu).toFixed(1);
                document.getElementById('kelembapanValue').textContent = parseFloat(data.sensor.kelembapan).toFixed(1);
                document.getElementById('gasValue').textContent = data.sensor.gas;
                document.getElementById('cahayaValue').textContent = data.sensor.cahaya;

                updateStatusBadge('statusSuhu', data.sensor.status_suhu);
                updateStatusBadge('statusGas', data.sensor.status_gas);
                updateStatusBadge('statusCahaya', data.sensor.status_cahaya);
            }
        }

        function updateStatusBadge(elementId, status) {
            const element = document.getElementById(elementId);
            element.textContent = status;
            
            element.className = 'px-3 py-1 text-xs font-medium rounded-full ';
            if (status === 'NORMAL' || status === 'TERANG') {
                element.className += 'bg-green-100 text-green-600';
            } else if (status === 'TINGGI' || status === 'PANAS') {
                element.className += 'bg-red-100 text-red-600';
            } else if (status === 'DINGIN' || status === 'GELAP') {
                element.className += 'bg-blue-100 text-blue-600';
            } else {
                element.className += 'bg-gray-100 text-gray-600';
            }
        }

        function updateComponentDisplay(data) {
            if (data.component) {
                updateComponentStatus('kipasmasuk', data.component.kipas_masuk, data.manual_control?.kipas_masuk);
                updateComponentStatus('kipasKeluar', data.component.kipas_keluar, data.manual_control?.kipas_keluar);
                updateComponentStatus('lampuHangat', data.component.lampu_hangat, data.manual_control?.lampu_hangat);
                updateComponentStatus('lampuTerang', data.component.lampu_terang, data.manual_control?.lampu_terang);
                updateComponentStatus('conveyor', data.component.conveyor, data.manual_control?.conveyor);
                updateComponentStatus('buzzer', data.component.buzzer, null);
            }
        }

        function updateComponentStatus(name, status, manualControl) {
            const indicator = document.getElementById(name + 'Indicator');
            const statusEl = document.getElementById(name + 'Status');
            const modeEl = document.getElementById(name + 'Mode');

            if (indicator && statusEl) {
                if (parseInt(status) === 1) {
                    indicator.className = 'status-indicator status-on';
                    statusEl.textContent = 'HIDUP';
                    statusEl.className = 'font-medium text-green-600';
                } else {
                    indicator.className = 'status-indicator status-off';
                    statusEl.textContent = 'MATI';
                    statusEl.className = 'font-medium text-gray-600';
                }
            }

            if (modeEl && manualControl !== null && manualControl !== undefined) {
                if (manualControl.is_manual === 1) {
                    modeEl.textContent = 'MANUAL';
                    modeEl.className = 'text-xs px-2 py-1 rounded-full bg-orange-100 text-orange-600';
                } else {
                    modeEl.textContent = 'AUTO';
                    modeEl.className = 'text-xs px-2 py-1 rounded-full bg-green-100 text-green-600';
                }
            }
        }

        fetchData();
        setInterval(fetchData, 3000);
    </script>
</body>
</html>

