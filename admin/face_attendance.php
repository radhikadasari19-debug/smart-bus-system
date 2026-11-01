
<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Face Attendance</title>
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script defer src="../assets/js/admin-face-attendance.js"></script>
    <style>
        body { font-family: Arial; text-align: center; background: #f4f6f9; }
        video { width: 640px; max-width: 95%; border: 3px solid #333; border-radius: 10px; }
        button { padding: 12px 22px; margin: 12px; cursor: pointer; }
        #status { font-weight: bold; margin: 15px; }
    </style>
</head>
<body>

<h2>Admin Face Recognition Attendance</h2>

<video id="video" autoplay muted playsinline></video>

<div>
    <button id="startBtn">Start Attendance</button>
    <button id="stopBtn" disabled>Stop Attendance</button>
</div>

<p id="status">Click Start Attendance to begin.</p>
<div id="result"></div>

</body>
</html>
