<?php

session_start();

if(!isset($_SESSION['student_id'])){
header("Location: ../login.php");
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Student Dashboard</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="sidebar">

<h2>Student Panel</h2>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="attendance.php">📅 Attendance</a>

<a href="tracking.php">🚌 Bus Tracking</a>

<a href="payment.php">💳 Payment</a>

<a href="../logout.php">🚪 Logout</a>

</div>

<div class="main">

<div class="topbar">

<h1>Welcome <?php echo $_SESSION['username']; ?></h1>

<button class="toggle-btn" onclick="toggleMode()">
Dark / Light
</button>

</div>

<div class="card">

<h2>Student Dashboard</h2>

<p>Smart College Bus Management System</p>

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