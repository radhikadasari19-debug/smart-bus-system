<?php

include '../includes/db.php';

$id = $_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM students WHERE id='$id'");

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$username = $_POST['username'];
$email = $_POST['email'];
$route = $_POST['bus_route'];
$payment = $_POST['payment_status'];

mysqli_query($conn,
"UPDATE students SET
username='$username',
email='$email',
bus_route='$route',
payment_status='$payment'
WHERE id='$id'");

header("Location: students.php");

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Update Student</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="main">

<div class="card">

<h2>Update Student</h2>

<form method="POST">

<input type="text"
name="username"
value="<?php echo $row['username']; ?>">

<input type="email"
name="email"
value="<?php echo $row['email']; ?>">

<input type="text"
name="bus_route"
value="<?php echo $row['bus_route']; ?>">

<select name="payment_status">

<option value="Paid">Paid</option>

<option value="Unpaid">Unpaid</option>

</select>

<button type="submit" name="update">
Update Student
</button>

</form>

</div>

</div>

</body>
</html>