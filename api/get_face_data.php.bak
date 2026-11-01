<?php

session_start();

header("Content-Type: application/json");

if (empty($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode([
        "ok" => false,
        "message" => "Admin login required"
    ]);
    exit;
}

require '../config/db.php';

$sql = "SELECT
        s.id,
        s.name,
        s.roll_number,
        f.face_encoding

        FROM students s

        INNER JOIN face_data f
        ON s.id = f.student_id";

$stmt = $pdo->query($sql);

$students = $stmt->fetchAll();

foreach ($students as &$student) {

    $student['face_encoding'] =
        json_decode($student['face_encoding'], true);

}

unset($student);

echo json_encode([
    "ok" => true,
    "students" => $students
]);

?>