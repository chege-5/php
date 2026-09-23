<?php

require_once __DIR__ . '/../../config/database.php';

$countyId = $_GET['county_id'] ?? null;

if ($countyId !== null && !ctype_digit((string) $countyId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid county_id']);
    exit;
}

if ($countyId === null) {
    $stmt = $pdo->query('SELECT id, name FROM wards ORDER BY name');
} else {
    $stmt = $pdo->prepare('SELECT id, name FROM wards WHERE county_id = :county_id ORDER BY name');
    $stmt->execute(['county_id' => (int) $countyId]);
}

echo json_encode($stmt->fetchAll());
