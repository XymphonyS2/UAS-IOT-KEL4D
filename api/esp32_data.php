<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_control') {
    $stmt = $conn->prepare("
        UPDATE manual_control 
        SET is_manual = 0, manual_value = 0, manual_start_time = NULL 
        WHERE is_manual = 1 
        AND manual_start_time IS NOT NULL 
        AND TIMESTAMPDIFF(MINUTE, manual_start_time, NOW()) >= timeout_minutes
    ");
    $stmt->execute();
    $stmt->close();

    $result = $conn->query("SELECT component_name, is_manual, manual_value FROM manual_control");
    
    $response = [
        'manual_kipas_masuk' => 0,
        'manual_kipas_keluar' => 0,
        'manual_lampu_hangat' => 0,
        'manual_lampu_terang' => 0,
        'manual_conveyor' => 0,
        'kipas_masuk_value' => 0,
        'kipas_keluar_value' => 0,
        'lampu_hangat_value' => 0,
        'lampu_terang_value' => 0,
        'conveyor_value' => 0
    ];

    while ($row = $result->fetch_assoc()) {
        $component = $row['component_name'];
        $response['manual_' . $component] = (int)$row['is_manual'];
        $response[$component . '_value'] = (int)$row['manual_value'];
    }

    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit();
    }

    $stmt = $conn->prepare("
        INSERT INTO sensor_data (suhu, kelembapan, gas, cahaya, status_suhu, status_gas, status_cahaya) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $suhu = $data['suhu'] ?? 0;
    $kelembapan = $data['kelembapan'] ?? 0;
    $gas = $data['gas'] ?? 0;
    $cahaya = $data['cahaya'] ?? 0;
    $status_suhu = $data['status_suhu'] ?? '';
    $status_gas = $data['status_gas'] ?? '';
    $status_cahaya = $data['status_cahaya'] ?? '';

    $stmt->bind_param("ddiisss", $suhu, $kelembapan, $gas, $cahaya, $status_suhu, $status_gas, $status_cahaya);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("
        UPDATE component_status SET 
            kipas_masuk = ?,
            kipas_keluar = ?,
            lampu_hangat = ?,
            lampu_terang = ?,
            conveyor = ?,
            buzzer = ?,
            manual_kipas_masuk = ?,
            manual_kipas_keluar = ?,
            manual_lampu_hangat = ?,
            manual_lampu_terang = ?,
            manual_conveyor = ?
        WHERE id = 1
    ");

    $kipas_masuk = $data['kipas_masuk'] ?? 0;
    $kipas_keluar = $data['kipas_keluar'] ?? 0;
    $lampu_hangat = $data['lampu_hangat'] ?? 0;
    $lampu_terang = $data['lampu_terang'] ?? 0;
    $conveyor = $data['conveyor'] ?? 0;
    $buzzer = $data['buzzer'] ?? 0;
    $manual_kipas_masuk = $data['manual_kipas_masuk'] ?? 0;
    $manual_kipas_keluar = $data['manual_kipas_keluar'] ?? 0;
    $manual_lampu_hangat = $data['manual_lampu_hangat'] ?? 0;
    $manual_lampu_terang = $data['manual_lampu_terang'] ?? 0;
    $manual_conveyor = $data['manual_conveyor'] ?? 0;

    $stmt->bind_param("iiiiiiiiiii", 
        $kipas_masuk, $kipas_keluar, $lampu_hangat, $lampu_terang, 
        $conveyor, $buzzer, $manual_kipas_masuk, $manual_kipas_keluar, 
        $manual_lampu_hangat, $manual_lampu_terang, $manual_conveyor
    );
    $stmt->execute();
    $stmt->close();

    $conn->query("DELETE FROM sensor_data WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)");

    echo json_encode(['status' => 'success', 'message' => 'Data received']);
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
$conn->close();
?>

