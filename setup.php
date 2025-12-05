<?php

require_once 'config.php';

$message = '';
$success = false;

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $conn = getDBConnection();
    
    $result = $conn->query("SELECT id FROM users WHERE username = 'admin'");
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        $message = "Password admin berhasil di-reset!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, nama_lengkap) VALUES ('admin', ?, 'Administrator')");
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        $message = "User admin berhasil dibuat!";
    }
    
    $success = true;
    $conn->close();
    
} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - CIMON</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-800 to-blue-600 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center">
        <?php if ($success): ?>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Setup Berhasil!</h1>
            <p class="text-gray-600 mb-6"><?php echo $message; ?></p>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left">
                <p class="text-sm text-gray-500 mb-2">Login dengan:</p>
                <p class="font-mono text-gray-800"><strong>Username:</strong> admin</p>
                <p class="font-mono text-gray-800"><strong>Password:</strong> admin123</p>
            </div>
            
            <a href="index.php" class="inline-block w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                Ke Halaman Login
            </a>
            
            <p class="text-xs text-red-500 mt-4">⚠️ Hapus file setup.php ini setelah selesai!</p>
        <?php else: ?>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Setup Gagal!</h1>
            <p class="text-red-600 mb-6"><?php echo $message; ?></p>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-left text-sm">
                <p class="font-semibold text-yellow-800 mb-2">Pastikan:</p>
                <ul class="text-yellow-700 space-y-1">
                    <li>• MySQL/MariaDB sudah berjalan</li>
                    <li>• Database "cimon" sudah dibuat</li>
                    <li>• Tabel "users" sudah ada</li>
                </ul>
            </div>
            
            <button onclick="location.reload()" class="mt-4 w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition-colors">
                Coba Lagi
            </button>
        <?php endif; ?>
    </div>
</body>
</html>

