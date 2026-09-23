<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';

$stmt = $pdo->query('SELECT id, name FROM continents ORDER BY name');
$continents = $stmt->fetchAll();

echo json_encode($continents);
