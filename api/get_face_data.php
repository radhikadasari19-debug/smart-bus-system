
<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT s.id, s.name, f.face_encoding
        FROM students s
        INNER JOIN face_data f ON f.student_id = s.id
    ");

    $students = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $descriptor = json_decode($row['face_encoding'], true);

        if (!is_array($descriptor) || count($descriptor) !== 128) {
            continue;
        }

        $students[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'descriptor' => array_map('floatval', $descriptor)
        ];
    }

    echo json_encode([
        'success' => true,
        'students' => $students
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unable to load registered faces.'
    ]);
}
