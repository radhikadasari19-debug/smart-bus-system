<?php

include '../includes/db.php';

date_default_timezone_set("Asia/Kolkata");

/* SELECT DATE */

if(isset($_GET['date'])){

    $selected_date = $_GET['date'];

}else{

    $selected_date = date('Y-m-d');
}

/* TOTAL STUDENTS */

$total_students = mysqli_num_rows(

mysqli_query($conn,
"SELECT * FROM students")

);

/* PRESENT COUNT */

$total_present = mysqli_num_rows(

mysqli_query($conn,

"SELECT * FROM attendance

WHERE attendance_date='$selected_date'")

);

/* ABSENT COUNT */

$total_absent = $total_students - $total_present;

?>

<!DOCTYPE html>
<html>
<head>

<title>Date Wise Attendance</title>

<link rel="stylesheet"
href="../assets/css/style.css">

<style>

.present{
color:limegreen;
font-weight:bold;
}

.absent{
color:red;
font-weight:bold;
}

.summary{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;

margin-bottom:30px;
}

.summary-box{

background:
linear-gradient(
135deg,
#2563eb,
#1d4ed8
);

padding:25px;

border-radius:20px;

color:white;

text-align:center;
}

.date-form{

margin-bottom:30px;
}

.date-form input{

padding:12px;

border-radius:10px;

border:1px solid #ccc;
}

.date-form button{

padding:12px 18px;

background:#2563eb;

color:white;

border:none;

border-radius:10px;

cursor:pointer;
}

</style>

</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="main">

<div class="topbar">

<h1>📅 Date Wise Attendance</h1>

<button class="toggle-btn"
onclick="toggleMode()">

🌙 Dark / ☀ Light

</button>

</div>

<!-- DATE FILTER -->

<form method="GET"
class="date-form">

<input
type="date"
name="date"

value="<?php echo $selected_date; ?>">

<button type="submit">

Search

</button>

</form>

<!-- SUMMARY -->

<div class="summary">

<div class="summary-box">

<h2>Total Students</h2>

<h1>
<?php echo $total_students; ?>
</h1>

</div>

<div class="summary-box">

<h2>Present</h2>

<h1>
<?php echo $total_present; ?>
</h1>

</div>

<div class="summary-box">

<h2>Absent</h2>

<h1>
<?php echo $total_absent; ?>
</h1>

</div>

</div>

<!-- TABLE -->

<div class="card">

<h2>

Attendance Report

(
<?php echo $selected_date; ?>
)

</h2>

<br>

<table>

<tr>

<th>ID</th>
<th>Student Name</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>

</tr>

<?php

$students = mysqli_query($conn,

"SELECT * FROM students");

while($student=mysqli_fetch_assoc($students)){

$student_id = $student['id'];

$attendance = mysqli_query($conn,

"SELECT * FROM attendance

WHERE student_id='$student_id'

AND attendance_date='$selected_date'");

if(mysqli_num_rows($attendance)>0){

$row = mysqli_fetch_assoc($attendance);

$status = "Present";

$time = $row['attendance_time'];

}else{

$status = "Absent";

$time = "--";
}

?>

<tr>

<td>
<?php echo $student['id']; ?>
</td>

<td>
<?php echo $student['username']; ?>
</td>

<td>
<?php echo $selected_date; ?>
</td>

<td>
<?php echo $time; ?>
</td>

<td>

<?php

if($status=="Present"){

echo "<span class='present'>
✅ Present
</span>";

}else{

echo "<span class='absent'>
❌ Absent
</span>";
}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<script>

function toggleMode(){

document.body.classList.toggle('dark');

if(document.body.classList.contains('dark')){

localStorage.setItem('theme','dark');

}else{

localStorage.setItem('theme','light');

}

}

if(localStorage.getItem('theme')==='dark'){

document.body.classList.add('dark');

}

</script>

</body>
</html>