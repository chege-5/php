<?php

require_once __DIR__ . '/../../config/database.php';

$wardId = $_GET['ward_id'] ?? null;

if ($wardId !== null && !ctype_digit((string) $wardId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ward_id']);
    exit;
}

if ($wardId === null) {
    $stmt = $pdo->query('SELECT id, name FROM villages ORDER BY name');
} else {
    $stmt = $pdo->prepare('SELECT id, name FROM villages WHERE ward_id = :ward_id ORDER BY name');
    $stmt->execute(['ward_id' => (int) $wardId]);
}

echo json_encode($stmt->fetchAll());
