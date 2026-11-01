<!DOCTYPE html>
<html>
<head>

<title>Bus Tracking</title>

<link rel="stylesheet" href="../assets/css/style.css">

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>

</head>

<body>

<?php include '../includes/header.php'; ?>

<div class="main">

<div class="card">

<h2>Live Bus Tracking</h2>

<div id="map"
style="height:500px;border-radius:20px;">
</div>

</div>

</div>

<script>

function initMap(){

var location = {
lat:19.0760,
lng:72.8777
};

var map = new google.maps.Map(
document.getElementById('map'),
{
zoom:12,
center:location
}
);

new google.maps.Marker({
position:location,
map:map
});

}

window.onload = initMap;

</script>

</body>
</html>