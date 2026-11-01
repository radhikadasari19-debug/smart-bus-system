<?php

include '../includes/db.php';

$total_students = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM students"));

$total_attendance = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM attendance"));

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="main">

<div class="topbar">

<h1>Admin Dashboard</h1>

<button class="toggle-btn" onclick="toggleMode()">
Dark / Light
</button>

</div>

<div class="dashboard-grid">

<div class="dashboard-box">
<h2>Total Students</h2>
<h1><?php echo $total_students; ?></h1>
</div>

<div class="dashboard-box">
<h2>Attendance</h2>
<h1><?php echo $total_attendance; ?></h1>
</div>

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