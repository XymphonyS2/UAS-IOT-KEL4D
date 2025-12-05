<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config.php';

$conn = getDBConnection();

$result = $conn->query("
    SELECT 
        suhu, 
        kelembapan, 
        gas, 
        cahaya, 
        DATE_FORMAT(created_at, '%H:%i:%s') as time,
        created_at
    FROM sensor_data 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 HOUR)
    ORDER BY created_at ASC
");

$data = [
    'suhu' => [],
    'kelembapan' => [],
    'gas' => [],
    'cahaya' => [],
    'labels' => []
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['suhu'][] = floatval($row['suhu']);
        $data['kelembapan'][] = floatval($row['kelembapan']);
        $data['gas'][] = intval($row['gas']);
        $data['cahaya'][] = intval($row['cahaya']);
        $data['labels'][] = $row['time'];
    }
}

$response = [
    'status' => 'success',
    'data' => $data,
    'count' => count($data['labels']),
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($response);
$conn->close();
?>

