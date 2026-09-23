<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';

$continentId = $_GET['continent_id'] ?? null;

if ($continentId !== null && !ctype_digit((string) $continentId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid continent_id']);
    exit;
}

if ($continentId === null) {
    $stmt = $pdo->query('SELECT id, name FROM countries ORDER BY name');
} else {
    $stmt = $pdo->prepare('SELECT id, name FROM countries WHERE continent_id = :continent_id ORDER BY name');
    $stmt->execute(['continent_id' => (int) $continentId]);
}

echo json_encode($stmt->fetchAll());
