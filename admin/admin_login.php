<?php

session_start();

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username=="admin" && $password=="admin123"){

        $_SESSION['admin']=true;

        header("Location: dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="main">

<div class="card">

<h2>Admin Login</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username">

<input type="password" name="password" placeholder="Password">

<button type="submit" name="login">
Login
</button>

</form>

</div>

</div>

</body>
</html>