<?php

include '../includes/db.php';

/* GET STUDENT ID */

$id = $_GET['id'];

/* DELETE ATTENDANCE */

mysqli_query($conn,

"DELETE FROM attendance
WHERE student_id='$id'");

/* DELETE PAYMENTS */

mysqli_query($conn,

"DELETE FROM payments
WHERE student_id='$id'");

/* DELETE STUDENT */

mysqli_query($conn,

"DELETE FROM students
WHERE id='$id'");

/* REDIRECT */

header("Location: students.php");

?>