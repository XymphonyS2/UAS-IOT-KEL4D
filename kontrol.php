<?php
require_once 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontrol Manual - CHICKMON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        .nav-item { transition: all 0.2s ease; }
        .nav-item:hover { background: rgba(255,255,255,0.1); }
        .nav-item.active { background: rgba(255,255,255,0.2); border-right: 3px solid white; }
        .pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .control-card { transition: all 0.3s ease; }
        .control-card:hover { transform: translateY(-2px); }
        .status-indicator { width: 14px; height: 14px; border-radius: 50%; }
        .status-on { background: #22c55e; box-shadow: 0 0 12px #22c55e; }
        .status-off { background: #ef4444; box-shadow: 0 0 12px #ef4444; }
        
        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: 0.3s;
            border-radius: 30px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        input:checked + .toggle-slider {
            background-color: #22c55e;
        }
        input:checked + .toggle-slider:before {
            transform: translateX(30px);
        }
        .toggle-switch.disabled .toggle-slider {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-gradient text-white flex flex-col flex-shrink-0">
            <!-- Logo -->
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

            <!-- Navigation -->
            <nav class="flex-1 py-6">
                <ul class="space-y-1 px-3">
                    <li>
                        <a href="dashboard.php" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-white/70 hover:text-white">
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
                        <a href="kontrol.php" class="nav-item active flex items-center gap-3 px-4 py-3 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="font-medium">Kontrol Manual</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Info -->
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

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kontrol Manual</h2>
                        <p class="text-sm text-gray-500">Kontrol komponen secara manual (timeout: 5 menit)</p>
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
                <!-- Info Banner -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-8 flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-800">Informasi Kontrol Manual</h4>
                        <p class="text-sm text-blue-600 mt-1">
                            Kontrol manual akan aktif selama <strong>5 menit</strong>. Setelah timeout, sistem akan kembali ke mode otomatis.
                            Anda dapat menekan tombol <strong>"Auto"</strong> untuk kembali ke mode otomatis secara manual.
                        </p>
                    </div>
                </div>

                <!-- Control Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kipas Masuk -->
                    <div class="control-card bg-white rounded-2xl p-6 card-shadow" id="card_kipas_masuk">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg">Kipas Masuk</h3>
                                <p class="text-sm text-gray-500">Intake Fan</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="kipas_masuk_indicator" class="status-indicator status-off"></div>
                                <span id="kipas_masuk_status" class="font-semibold text-gray-600">MATI</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Mode:</span>
                            <span id="kipas_masuk_mode" class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600">AUTO</span>
                        </div>

                        <div id="kipas_masuk_timer" class="mb-4 hidden">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-500">Sisa waktu manual:</span>
                                <span id="kipas_masuk_remaining" class="font-medium text-orange-600">5:00</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div id="kipas_masuk_progress" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <button onclick="setControl('kipas_masuk', 'off')" 
                                class="flex-1 py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-600 font-medium rounded-xl transition-colors">
                                Matikan
                            </button>
                            <button onclick="setControl('kipas_masuk', 'on')" 
                                class="flex-1 py-2.5 px-4 bg-green-100 hover:bg-green-200 text-green-600 font-medium rounded-xl transition-colors">
                                Hidupkan
                            </button>
                            <button onclick="setControl('kipas_masuk', 'auto')" 
                                class="py-2.5 px-4 bg-blue-100 hover:bg-blue-200 text-blue-600 font-medium rounded-xl transition-colors">
                                Auto
                            </button>
                        </div>
                    </div>

                    <!-- Kipas Keluar -->
                    <div class="control-card bg-white rounded-2xl p-6 card-shadow" id="card_kipas_keluar">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg">Kipas Keluar</h3>
                                <p class="text-sm text-gray-500">Exhaust Fan</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="kipas_keluar_indicator" class="status-indicator status-off"></div>
                                <span id="kipas_keluar_status" class="font-semibold text-gray-600">MATI</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Mode:</span>
                            <span id="kipas_keluar_mode" class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600">AUTO</span>
                        </div>

                        <div id="kipas_keluar_timer" class="mb-4 hidden">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-500">Sisa waktu manual:</span>
                                <span id="kipas_keluar_remaining" class="font-medium text-orange-600">5:00</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div id="kipas_keluar_progress" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <button onclick="setControl('kipas_keluar', 'off')" 
                                class="flex-1 py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-600 font-medium rounded-xl transition-colors">
                                Matikan
                            </button>
                            <button onclick="setControl('kipas_keluar', 'on')" 
                                class="flex-1 py-2.5 px-4 bg-green-100 hover:bg-green-200 text-green-600 font-medium rounded-xl transition-colors">
                                Hidupkan
                            </button>
                            <button onclick="setControl('kipas_keluar', 'auto')" 
                                class="py-2.5 px-4 bg-blue-100 hover:bg-blue-200 text-blue-600 font-medium rounded-xl transition-colors">
                                Auto
                            </button>
                        </div>
                    </div>

                    <!-- Lampu Penghangat -->
                    <div class="control-card bg-white rounded-2xl p-6 card-shadow" id="card_lampu_hangat">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg">Lampu Penghangat</h3>
                                <p class="text-sm text-gray-500">Heater Lamp</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="lampu_hangat_indicator" class="status-indicator status-off"></div>
                                <span id="lampu_hangat_status" class="font-semibold text-gray-600">MATI</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Mode:</span>
                            <span id="lampu_hangat_mode" class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600">AUTO</span>
                        </div>

                        <div id="lampu_hangat_timer" class="mb-4 hidden">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-500">Sisa waktu manual:</span>
                                <span id="lampu_hangat_remaining" class="font-medium text-orange-600">5:00</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div id="lampu_hangat_progress" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <button onclick="setControl('lampu_hangat', 'off')" 
                                class="flex-1 py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-600 font-medium rounded-xl transition-colors">
                                Matikan
                            </button>
                            <button onclick="setControl('lampu_hangat', 'on')" 
                                class="flex-1 py-2.5 px-4 bg-green-100 hover:bg-green-200 text-green-600 font-medium rounded-xl transition-colors">
                                Hidupkan
                            </button>
                            <button onclick="setControl('lampu_hangat', 'auto')" 
                                class="py-2.5 px-4 bg-blue-100 hover:bg-blue-200 text-blue-600 font-medium rounded-xl transition-colors">
                                Auto
                            </button>
                        </div>
                    </div>

                    <!-- Lampu Penerangan -->
                    <div class="control-card bg-white rounded-2xl p-6 card-shadow" id="card_lampu_terang">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg">Lampu Penerangan</h3>
                                <p class="text-sm text-gray-500">Lighting</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="lampu_terang_indicator" class="status-indicator status-off"></div>
                                <span id="lampu_terang_status" class="font-semibold text-gray-600">MATI</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Mode:</span>
                            <span id="lampu_terang_mode" class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600">AUTO</span>
                        </div>

                        <div id="lampu_terang_timer" class="mb-4 hidden">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-500">Sisa waktu manual:</span>
                                <span id="lampu_terang_remaining" class="font-medium text-orange-600">5:00</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div id="lampu_terang_progress" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <button onclick="setControl('lampu_terang', 'off')" 
                                class="flex-1 py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-600 font-medium rounded-xl transition-colors">
                                Matikan
                            </button>
                            <button onclick="setControl('lampu_terang', 'on')" 
                                class="flex-1 py-2.5 px-4 bg-green-100 hover:bg-green-200 text-green-600 font-medium rounded-xl transition-colors">
                                Hidupkan
                            </button>
                            <button onclick="setControl('lampu_terang', 'auto')" 
                                class="py-2.5 px-4 bg-blue-100 hover:bg-blue-200 text-blue-600 font-medium rounded-xl transition-colors">
                                Auto
                            </button>
                        </div>
                    </div>

                    <!-- Conveyor -->
                    <div class="control-card bg-white rounded-2xl p-6 card-shadow" id="card_conveyor">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-lg">Conveyor</h3>
                                <p class="text-sm text-gray-500">Belt System</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="conveyor_indicator" class="status-indicator status-off"></div>
                                <span id="conveyor_status" class="font-semibold text-gray-600">MATI</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Mode:</span>
                            <span id="conveyor_mode" class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600">AUTO</span>
                        </div>

                        <div id="conveyor_timer" class="mb-4 hidden">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-500">Sisa waktu manual:</span>
                                <span id="conveyor_remaining" class="font-medium text-orange-600">5:00</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div id="conveyor_progress" class="bg-orange-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <button onclick="setControl('conveyor', 'off')" 
                                class="flex-1 py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-600 font-medium rounded-xl transition-colors">
                                Matikan
                            </button>
                            <button onclick="setControl('conveyor', 'on')" 
                                class="flex-1 py-2.5 px-4 bg-green-100 hover:bg-green-200 text-green-600 font-medium rounded-xl transition-colors">
                                Hidupkan
                            </button>
                            <button onclick="setControl('conveyor', 'auto')" 
                                class="py-2.5 px-4 bg-blue-100 hover:bg-blue-200 text-blue-600 font-medium rounded-xl transition-colors">
                                Auto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <div class="bg-gray-800 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
            <svg id="toastIcon" class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toastMessage">Berhasil!</span>
        </div>
    </div>

    <script>
        const TIMEOUT_SECONDS = 300;

        function showToast(message, success = true) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');
            
            toastMessage.textContent = message;
            toastIcon.className = success 
                ? 'w-5 h-5 text-green-400' 
                : 'w-5 h-5 text-red-400';
            
            toast.classList.remove('translate-y-20', 'opacity-0');
            
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        function setControl(component, action) {
            fetch('api/set_manual_control.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    component: component,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let message = '';
                    if (action === 'auto') {
                        message = `${formatComponentName(component)} beralih ke mode OTOMATIS`;
                    } else {
                        message = `${formatComponentName(component)} di${action === 'on' ? 'hidupkan' : 'matikan'} (Manual 5 menit)`;
                    }
                    showToast(message, true);
                    fetchData();
                } else {
                    showToast('Gagal: ' + data.message, false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan!', false);
            });
        }

        function formatComponentName(name) {
            const names = {
                'kipas_masuk': 'Kipas Masuk',
                'kipas_keluar': 'Kipas Keluar',
                'lampu_hangat': 'Lampu Penghangat',
                'lampu_terang': 'Lampu Penerangan',
                'conveyor': 'Conveyor'
            };
            return names[name] || name;
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        function updateComponentDisplay(name, componentData, manualControl) {
            const indicator = document.getElementById(name + '_indicator');
            const status = document.getElementById(name + '_status');
            const mode = document.getElementById(name + '_mode');
            const timer = document.getElementById(name + '_timer');
            const remaining = document.getElementById(name + '_remaining');
            const progress = document.getElementById(name + '_progress');

            if (indicator && status) {
                const isOn = componentData == 1;
                indicator.className = 'status-indicator ' + (isOn ? 'status-on' : 'status-off');
                status.textContent = isOn ? 'HIDUP' : 'MATI';
                status.className = 'font-semibold ' + (isOn ? 'text-green-600' : 'text-gray-600');
            }

            if (mode && manualControl) {
                const isManual = manualControl.is_manual === 1;
                if (isManual) {
                    mode.textContent = 'MANUAL';
                    mode.className = 'px-3 py-1 text-sm font-medium rounded-full bg-orange-100 text-orange-600';
                    
                    if (timer && remaining && progress) {
                        timer.classList.remove('hidden');
                        const remainingSecs = manualControl.remaining_seconds;
                        remaining.textContent = formatTime(remainingSecs);
                        progress.style.width = (remainingSecs / TIMEOUT_SECONDS * 100) + '%';
                    }
                } else {
                    mode.textContent = 'AUTO';
                    mode.className = 'px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-600';
                    
                    if (timer) {
                        timer.classList.add('hidden');
                    }
                }
            }
        }

        function fetchData() {
            fetch('api/get_sensor_data.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.component) {
                            updateComponentDisplay('kipas_masuk', data.component.kipas_masuk, data.manual_control?.kipas_masuk);
                            updateComponentDisplay('kipas_keluar', data.component.kipas_keluar, data.manual_control?.kipas_keluar);
                            updateComponentDisplay('lampu_hangat', data.component.lampu_hangat, data.manual_control?.lampu_hangat);
                            updateComponentDisplay('lampu_terang', data.component.lampu_terang, data.manual_control?.lampu_terang);
                            updateComponentDisplay('conveyor', data.component.conveyor, data.manual_control?.conveyor);
                        }
                        
                        document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('id-ID');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        fetchData();
        setInterval(fetchData, 3000);
    </script>
</body>
</html>

