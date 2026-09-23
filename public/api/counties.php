<?php

require_once __DIR__ . '/../../config/database.php';

$countryId = $_GET['country_id'] ?? null;

if ($countryId !== null && !ctype_digit((string) $countryId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid country_id']);
    exit;
}

if ($countryId === null) {
    $stmt = $pdo->query('SELECT id, name FROM counties ORDER BY name');
} else {
    $stmt = $pdo->prepare('SELECT id, name FROM counties WHERE country_id = :country_id ORDER BY name');
    $stmt->execute(['country_id' => (int) $countryId]);
}

echo json_encode($stmt->fetchAll());
