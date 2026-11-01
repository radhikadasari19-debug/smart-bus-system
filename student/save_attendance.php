<?php

session_start();

include '../includes/db.php';

date_default_timezone_set("Asia/Kolkata");

$student_id = $_SESSION['student_id'];

$current_date = date('Y-m-d');

$current_time = date('h:i:s A');

/* CHECK DAILY ATTENDANCE */

$check = mysqli_query($conn,

"SELECT * FROM attendance

WHERE student_id='$student_id'

AND attendance_date='$current_date'");

if(mysqli_num_rows($check)>0){

echo "Attendance Already Marked";

}else{

mysqli_query($conn,

"INSERT INTO attendance(

student_id,
attendance_date,
attendance_time,
status

)

VALUES(

'$student_id',
'$current_date',
'$current_time',
'Present'

)");

echo "Attendance Marked Successfully";
}

?>