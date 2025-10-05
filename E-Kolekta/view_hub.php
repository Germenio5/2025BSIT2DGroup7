<?php
session_start();
?>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="content-wrapper">
    <?php include "views/sidebar.php"; ?>

    <div class="main-content">
        <div id="dropoff_text">MAP FOR HUB AND DROP-OFF POINT</div>

        <div class="map-placeholder">
            <p>Map will be displayed here</p>
        </div>

        <div class="dropoff-container">
            <div class="dropoff">
                <h3>DROP-OFF POINT 1</h3>
                <p><strong>Location:</strong> Central Hub</p>
                <p><strong>Operating Hours:</strong> Mon–Sat, 8:00 AM – 6:00 PM</p>
                <p><strong>Contact:</strong> 09134567891</p>
                <p><strong>Status:</strong> <span class="status-full">FULL</span></p>
            </div>

            <div class="dropoff">
                <h3>DROP-OFF POINT 2</h3>
                <p><strong>Location:</strong> City Hall</p>
                <p><strong>Operating Hours:</strong> Mon-Sun, 9:00 AM – 4:00 PM</p>
                <p><strong>Contact:</strong> 09145267728</p>
                <p><strong>Status:</strong> <span class="status-available">AVAILABLE</span></p>
            </div>

            <div class="dropoff">
                <h3>DROP-OFF POINT 3</h3>
                <p><strong>Location:</strong> Public Plaza</p>
                <p><strong>Operating Hours:</strong> Mon–Fri, 8:00 AM – 5:00 PM</p>
                <p><strong>Contact:</strong> 09271924731</p>
                <p><strong>Status:</strong> <span class="status-maintenance">MAINTENANCE</span></p>
            </div>
        </div>
    </div>
</body>
</html>