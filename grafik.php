<?php
require_once 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik - CHICKMON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .nav-item { transition: all 0.2s ease; }
        .nav-item:hover { background: rgba(255,255,255,0.1); }
        .nav-item.active { background: rgba(255,255,255,0.2); border-right: 3px solid white; }
        .pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
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
                        <a href="grafik.php" class="nav-item active flex items-center gap-3 px-4 py-3 rounded-lg">
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
                        <h2 class="text-2xl font-bold text-gray-800">Grafik Histori</h2>
                        <p class="text-sm text-gray-500">Data sensor 7 jam terakhir</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-500 rounded-full pulse"></div>
                            <span>Live Update</span>
                        </div>
                        <div id="lastUpdate" class="text-sm text-gray-500">--:--:--</div>
                        <div id="dataCount" class="text-sm text-gray-400 bg-gray-100 px-3 py-1 rounded-full">0 data points</div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                <!-- Charts Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Suhu Chart -->
                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Suhu</h3>
                                    <p class="text-sm text-gray-500">Temperature (°C)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p id="currentSuhu" class="text-2xl font-bold text-red-500">--</p>
                                <p class="text-xs text-gray-400">Current</p>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="suhuChart"></canvas>
                        </div>
                    </div>

                    <!-- Kelembapan Chart -->
                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Kelembapan</h3>
                                    <p class="text-sm text-gray-500">Humidity (%)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p id="currentKelembapan" class="text-2xl font-bold text-blue-500">--</p>
                                <p class="text-xs text-gray-400">Current</p>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="kelembapanChart"></canvas>
                        </div>
                    </div>

                    <!-- Gas Chart -->
                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Gas Amonia</h3>
                                    <p class="text-sm text-gray-500">MQ135 (ppm)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p id="currentGas" class="text-2xl font-bold text-yellow-500">--</p>
                                <p class="text-xs text-gray-400">Current</p>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="gasChart"></canvas>
                        </div>
                    </div>

                    <!-- Cahaya Chart -->
                    <div class="bg-white rounded-2xl p-6 card-shadow">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Cahaya</h3>
                                    <p class="text-sm text-gray-500">LDR (lux)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p id="currentCahaya" class="text-2xl font-bold text-amber-500">--</p>
                                <p class="text-xs text-gray-400">Current</p>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="cahayaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const chartConfig = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        ticks: { 
                            maxTicksLimit: 8,
                            font: { size: 10 }
                        }
                    },
                    y: {
                        display: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { size: 10 } }
                    }
                },
                elements: {
                    line: { tension: 0.4 },
                    point: { radius: 0, hoverRadius: 4 }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        };

        const suhuChart = new Chart(document.getElementById('suhuChart'), {
            ...chartConfig,
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    borderWidth: 2
                }]
            }
        });

        const kelembapanChart = new Chart(document.getElementById('kelembapanChart'), {
            ...chartConfig,
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    borderWidth: 2
                }]
            }
        });

        const gasChart = new Chart(document.getElementById('gasChart'), {
            ...chartConfig,
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    borderColor: '#eab308',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    fill: true,
                    borderWidth: 2
                }]
            }
        });

        const cahayaChart = new Chart(document.getElementById('cahayaChart'), {
            ...chartConfig,
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    borderWidth: 2
                }]
            }
        });

        function fetchChartData() {
            fetch('api/get_chart_data.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateCharts(data.data);
                        document.getElementById('dataCount').textContent = data.count + ' data points';
                        document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('id-ID');

                        if (data.data.suhu.length > 0) {
                            const lastIndex = data.data.suhu.length - 1;
                            document.getElementById('currentSuhu').textContent = data.data.suhu[lastIndex].toFixed(1) + '°C';
                            document.getElementById('currentKelembapan').textContent = data.data.kelembapan[lastIndex].toFixed(1) + '%';
                            document.getElementById('currentGas').textContent = data.data.gas[lastIndex];
                            document.getElementById('currentCahaya').textContent = data.data.cahaya[lastIndex];
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateCharts(data) {
            suhuChart.data.labels = data.labels;
            suhuChart.data.datasets[0].data = data.suhu;
            suhuChart.update('none');

            kelembapanChart.data.labels = data.labels;
            kelembapanChart.data.datasets[0].data = data.kelembapan;
            kelembapanChart.update('none');

            gasChart.data.labels = data.labels;
            gasChart.data.datasets[0].data = data.gas;
            gasChart.update('none');

            cahayaChart.data.labels = data.labels;
            cahayaChart.data.datasets[0].data = data.cahaya;
            cahayaChart.update('none');
        }

        fetchChartData();
        setInterval(fetchChartData, 3000);
    </script>
</body>
</html>

