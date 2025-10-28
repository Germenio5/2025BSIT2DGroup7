<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hub</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="content-wrapper">
    <?php include "views/sidebar.php"; ?>
    <div class="main-content">
        <div id="dropoff_text">MAP FOR HUB AND DROP-OFF POINT</div>

        <div class="map-placeholder">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10466.368280151226!2d122.95786823119442!3d10.699085396448487!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33aed116a67c6b69%3A0x4e63341e8baf297!2sArt%20District!5e0!3m2!1sen!2sph!4v1761548979974!5m2!1sen!2sph" width="100%" height="400" style="border:1px solid black; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                <p><strong>Operating Hours:</strong> Mon–Sun, 9:00 AM – 4:00 PM</p>
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
</div>
</body>
</html>