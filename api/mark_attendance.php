
<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$studentId = filter_var(
    $data['student_id'] ?? null,
    FILTER_VALIDATE_INT
);

if (!$studentId || $studentId < 1) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid student ID.'
    ]);
    exit;
}

try {
    // Confirm that the student exists and has a registered face.
    $check = $pdo->prepare("
        SELECT s.id
        FROM students s
        INNER JOIN face_data f ON f.student_id = s.id
        WHERE s.id = ?
    ");
    $check->execute([$studentId]);

    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Registered student not found.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT IGNORE INTO attendance
        (student_id, attendance_date, attendance_time, status)
        VALUES (?, CURDATE(), CURTIME(), 'Present')
    ");

    $stmt->execute([$studentId]);

    if ($stmt->rowCount() === 1) {
        echo json_encode([
            'success' => true,
            'message' => 'Attendance marked successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Attendance already marked today.'
        ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error while saving attendance.'
    ]);
}
