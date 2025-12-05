<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
    exit();
}

$component = $data['component'] ?? '';
$action = $data['action'] ?? '';

$validComponents = ['kipas_masuk', 'kipas_keluar', 'lampu_hangat', 'lampu_terang', 'conveyor'];

if (!in_array($component, $validComponents)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid component']);
    exit();
}

if (!in_array($action, ['on', 'off', 'auto'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit();
}

$conn = getDBConnection();

if ($action === 'auto') {
    $stmt = $conn->prepare("
        UPDATE manual_control 
        SET is_manual = 0, manual_value = 0, manual_start_time = NULL 
        WHERE component_name = ?
    ");
    $stmt->bind_param("s", $component);
    $stmt->execute();
    $stmt->close();

    echo json_encode([
        'status' => 'success',
        'message' => 'Switched to automatic mode',
        'component' => $component,
        'mode' => 'auto'
    ]);
} else {
    $manualValue = ($action === 'on') ? 1 : 0;
    
    $stmt = $conn->prepare("
        UPDATE manual_control 
        SET is_manual = 1, manual_value = ?, manual_start_time = NOW() 
        WHERE component_name = ?
    ");
    $stmt->bind_param("is", $manualValue, $component);
    $stmt->execute();
    $stmt->close();

    echo json_encode([
        'status' => 'success',
        'message' => 'Manual control set',
        'component' => $component,
        'mode' => 'manual',
        'value' => $manualValue,
        'timeout_minutes' => MANUAL_TIMEOUT_MINUTES
    ]);
}

$conn->close();
?>

