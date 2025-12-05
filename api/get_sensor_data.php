<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config.php';

$conn = getDBConnection();

$result = $conn->query("
    SELECT suhu, kelembapan, gas, cahaya, status_suhu, status_gas, status_cahaya, created_at 
    FROM sensor_data 
    ORDER BY created_at DESC 
    LIMIT 1
");

$sensorData = null;
if ($result && $result->num_rows > 0) {
    $sensorData = $result->fetch_assoc();
}

$result = $conn->query("SELECT * FROM component_status WHERE id = 1");
$componentStatus = null;
if ($result && $result->num_rows > 0) {
    $componentStatus = $result->fetch_assoc();
}

$result = $conn->query("
    SELECT 
        component_name, 
        is_manual, 
        manual_value,
        CASE 
            WHEN is_manual = 1 AND manual_start_time IS NOT NULL 
            THEN GREATEST(0, (timeout_minutes * 60) - TIMESTAMPDIFF(SECOND, manual_start_time, NOW()))
            ELSE 0 
        END as remaining_seconds
    FROM manual_control
");

$manualControl = [];
while ($row = $result->fetch_assoc()) {
    $manualControl[$row['component_name']] = [
        'is_manual' => (int)$row['is_manual'],
        'value' => (int)$row['manual_value'],
        'remaining_seconds' => (int)$row['remaining_seconds']
    ];
}

$response = [
    'status' => 'success',
    'sensor' => $sensorData,
    'component' => $componentStatus,
    'manual_control' => $manualControl,
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($response);
$conn->close();
?>

