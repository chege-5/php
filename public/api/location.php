<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';

if (!in_array($type, ['country', 'county', 'ward', 'village'], true) || !ctype_digit($id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid type or id']);
    exit;
}

$queries = [
    'country' => '
        SELECT cont.id AS continent_id, cou.id AS country_id,
               NULL::integer AS county_id, NULL::integer AS ward_id, NULL::integer AS village_id
        FROM countries cou
        JOIN continents cont ON cont.id = cou.continent_id
        WHERE cou.id = :id',
    'county' => '
        SELECT cont.id AS continent_id, cou.id AS country_id, ct.id AS county_id,
               NULL::integer AS ward_id, NULL::integer AS village_id
        FROM counties ct
        JOIN countries cou ON cou.id = ct.country_id
        JOIN continents cont ON cont.id = cou.continent_id
        WHERE ct.id = :id',
    'ward' => '
        SELECT cont.id AS continent_id, cou.id AS country_id, ct.id AS county_id, w.id AS ward_id,
               NULL::integer AS village_id
        FROM wards w
        JOIN counties ct ON ct.id = w.county_id
        JOIN countries cou ON cou.id = ct.country_id
        JOIN continents cont ON cont.id = cou.continent_id
        WHERE w.id = :id',
    'village' => '
        SELECT cont.id AS continent_id, cou.id AS country_id, ct.id AS county_id, w.id AS ward_id,
               v.id AS village_id
        FROM villages v
        JOIN wards w ON w.id = v.ward_id
        JOIN counties ct ON ct.id = w.county_id
        JOIN countries cou ON cou.id = ct.country_id
        JOIN continents cont ON cont.id = cou.continent_id
        WHERE v.id = :id'
];

$stmt = $pdo->prepare($queries[$type]);
$stmt->execute(['id' => (int) $id]);

$location = $stmt->fetch();

if (!$location) {
    http_response_code(404);
    echo json_encode(['error' => 'Location not found']);
    exit;
}

echo json_encode($location);
