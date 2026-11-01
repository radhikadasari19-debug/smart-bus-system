<?php

session_start();

include '../includes/db.php';

/* MAHARASHTRA / INDIA TIMEZONE */

date_default_timezone_set("Asia/Kolkata");

if(!isset($_SESSION['student_id'])){

    header("Location: ../login.php");
}

$student_id = $_SESSION['student_id'];

$message = "";

/* CURRENT DATE & TIME */

$current_date = date('Y-m-d');

$current_time = date('h:i:s A');

/* ATTENDANCE BUTTON */

if(isset($_POST['mark'])){

    /* CHECK TODAY ATTENDANCE */

    $check = mysqli_query($conn,

    "SELECT * FROM attendance

    WHERE student_id='$student_id'

    AND attendance_date='$current_date'");

    if(mysqli_num_rows($check) > 0){

        $message = "Attendance Already Marked Today";

    }else{

        /* LATE DETECTION */

        $current_hour = date('H');

        if($current_hour >= 10){

            $late_status = "Late";

        }else{

            $late_status = "On Time";
        }

        /* INSERT ATTENDANCE */

        mysqli_query($conn,

        "INSERT INTO attendance(

        student_id,
        attendance_date,
        attendance_time,
        status,
        face_status,
        late_status

        )

        VALUES(

        '$student_id',
        '$current_date',
        '$current_time',
        'Present',
        'Matched',
        '$late_status'

        )");

        $message = "Attendance Marked Successfully";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Face Attendance</title>

<link rel="stylesheet" href="../assets/css/style.css">

<script src="../assets/js/face-api.min.js"></script>

<style>

#video{

    width:450px;
    height:350px;
    border-radius:20px;
    border:4px solid #2563eb;
    object-fit:cover;
}

.success{

    background:green;
    color:white;
    padding:15px;
    border-radius:12px;
    margin-top:20px;
    text-align:center;
    font-size:20px;
}

.error{

    background:red;
    color:white;
    padding:15px;
    border-radius:12px;
    margin-top:20px;
    text-align:center;
    font-size:20px;
}

.time-box{

    margin-top:20px;
    background:var(--card);
    padding:20px;
    border-radius:15px;
    font-size:18px;
    line-height:35px;
}

.scan-btn{

    background:#2563eb;
    color:white;
    border:none;
    padding:14px;
    border-radius:12px;
    font-size:18px;
    cursor:pointer;
    width:100%;
}

.scan-btn:hover{

    opacity:0.9;
}

.camera-box{

    text-align:center;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h2>Student Panel</h2>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="attendance.php">📅 Attendance</a>

<a href="tracking.php">📍 Tracking</a>

<a href="payment.php">💳 Payment</a>

<a href="../logout.php">🚪 Logout</a>

</div>

<!-- MAIN -->

<div class="main">

<!-- TOPBAR -->

<div class="topbar">

<h1>📅 Face Recognition Attendance</h1>

<button class="toggle-btn" onclick="toggleMode()">
🌙 Dark / ☀ Light
</button>

</div>

<!-- ATTENDANCE CARD -->

<div class="card">

<h2>AI Face Attendance System</h2>

<br>

<div class="camera-box">

<!-- LIVE CAMERA -->

<video id="video" autoplay muted></video>

</div>

<!-- TIME -->

<div class="time-box">

📆 Current Date:
<b>
<?php echo $current_date; ?>
</b>

<br>

🕒 Maharashtra Time:
<b id="liveTime">
<?php echo $current_time; ?>
</b>

</div>

<!-- FORM -->

<form method="POST">

<br>

<button type="submit"
name="mark"
class="scan-btn">

✅ Scan Face & Mark Attendance

</button>

</form>

<!-- MESSAGE -->

<?php

if($message!=""){

    if($message=="Attendance Marked Successfully"){

        echo "<div class='success'>
        $message
        </div>";

    }else{

        echo "<div class='error'>
        $message
        </div>";
    }
}

?>

</div>

</div>

<script>

/* START CAMERA */

navigator.mediaDevices.getUserMedia({

video:true

})

.then(stream => {

document.getElementById('video').srcObject = stream;

})

.catch(error => {

alert("Camera Access Denied");

});

/* LIVE MAHARASHTRA TIME */

function updateTime(){

    let now = new Date();

    let options = {

        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'

    };

    let time = now.toLocaleTimeString('en-IN', options);

    document.getElementById("liveTime").innerHTML = time;
}

setInterval(updateTime,1000);

/* DARK MODE */

function toggleMode(){

document.body.classList.toggle('dark');

if(document.body.classList.contains('dark')){

localStorage.setItem('theme','dark');

}else{

localStorage.setItem('theme','light');

}

}

/* LOAD SAVED THEME */

if(localStorage.getItem('theme')==='dark'){

document.body.classList.add('dark');

}

</script>

</body>
</html>