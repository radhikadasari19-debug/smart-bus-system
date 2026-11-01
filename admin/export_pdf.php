<?php

include '../includes/db.php';

header("Content-Type: application/vnd.ms-excel");

header("Content-Disposition: attachment; filename=attendance_report.xls");

echo "Student Name\tDate\tTime\tStatus\n";

$query = mysqli_query($conn,

"SELECT students.username,
attendance.*

FROM attendance

JOIN students

ON students.id=attendance.student_id");

while($row=mysqli_fetch_assoc($query)){

echo $row['username']."\t";

echo $row['attendance_date']."\t";

echo $row['attendance_time']."\t";

echo $row['status']."\n";

}

?>