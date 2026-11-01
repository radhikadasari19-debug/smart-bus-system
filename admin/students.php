<?php

include '../includes/db.php';

$result = mysqli_query($conn,"SELECT * FROM students");

?>

<!DOCTYPE html>
<html>
<head>

<title>Students</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="main">

<div class="topbar">

<h1>Student Management</h1>

<button class="toggle-btn" onclick="toggleMode()">
Dark / Light
</button>

</div>

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Face</th>
<th>Name</th>
<th>Email</th>
<th>Route</th>
<th>Payment</th>
<th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<img class="face"
src="../uploads/faces/<?php echo $row['face_image']; ?>">
</td>

<td><?php echo $row['username']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['bus_route']; ?></td>

<td><?php echo $row['payment_status']; ?></td>

<td>

<a href="update_student.php?id=<?php echo $row['id']; ?>">
<button class="delete-btn">

Edit

</button>

</a>




</td>
<td>

<a href="delete_student.php?id=<?php echo $row['id']; ?>">

<button class="delete-btn">

 Delete

</button>

</a>

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