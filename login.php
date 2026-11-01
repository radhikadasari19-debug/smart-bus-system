<?php

session_start();

include 'includes/db.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,
    "SELECT * FROM students
    WHERE username='$username'
    AND password='$password'");

    if(mysqli_num_rows($query)>0){

        $row = mysqli_fetch_assoc($query);

        $_SESSION['student_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: student/dashboard.php");

    }else{
        echo "Invalid Login";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

<link rel="stylesheet" href="assets/css/style.css">
<style>

body{

display:flex;
justify-content:center;
align-items:center;
height:100vh;

background:
linear-gradient(
135deg,
#0f172a,
#2563eb
);

font-family:Arial;
}

/* LOGIN BOX */

.login-box{

width:420px;

background:white;

padding:40px;

border-radius:20px;

box-shadow:
0 10px 30px rgba(0,0,0,0.3);
}

.login-box h1{

text-align:center;

margin-bottom:30px;

color:#2563eb;
}

/* INPUT */

input{

width:100%;

padding:14px;

margin-top:15px;

border-radius:12px;

border:1px solid #ccc;

font-size:16px;
}

/* BUTTON */

button{

width:100%;

padding:14px;

margin-top:20px;

background:#2563eb;

color:white;

border:none;

border-radius:12px;

cursor:pointer;

font-size:18px;

font-weight:bold;
}

button:hover{

background:#1d4ed8;
}

/* ERROR MESSAGE */

.error-box{

background:#dc2626;

color:white;

padding:14px;

margin-top:20px;

border-radius:12px;

text-align:center;

font-size:18px;

font-weight:bold;

animation:shake 0.3s ease-in-out;

}

/* SHAKE EFFECT */

@keyframes shake{

0%{
transform:translateX(0);
}

25%{
transform:translateX(-5px);
}

50%{
transform:translateX(5px);
}

75%{
transform:translateX(-5px);
}

100%{
transform:translateX(0);
}

}

.register-link{

text-align:center;

margin-top:20px;
}

.register-link a{

color:white;

font-weight:bold;

text-decoration:none;
}

</style>


</head>

<body>
<div class="sidebar">

<h2>Smart Bus</h2>

<a href="index.php">🏠 Home</a>

<a href="register.php">📝 Register</a>

<a href="login.php">👨‍🎓 Student Login</a>

<a href="admin/admin_login.php">🛠 Admin Login</a>

</div>
<div class="main">

<div class="card">

<h2>Student Login</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username">

<input type="password" name="password" placeholder="Password">

<button type="submit" name="login">
Login
</button>

</form>

</div>
<div class="register-link">

Don't have account?

<a href="register.php">

Register Here

</a>

</div>

</div>

</body>
</html>