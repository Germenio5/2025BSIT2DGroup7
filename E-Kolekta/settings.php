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
        <div id="settings_text">SETTINGS</div>

        <div class="settings-box">
            <div class="profile-section">
                <div class="profile-pic">
                    <img src="images/user_icon.png" alt="Profile Picture">
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Change Profile Photo</span>
                <div class="setting-actions">
                    <a href="#" class="change-photo">Upload New</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Full Name:</span>
                <span class="setting-value">Juan Dela Cruz</span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Email:</span>
                <span class="setting-value">juandelacruz@email.com</span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Phone Number:</span>
                <span class="setting-value">+63 912 345 6789</span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Address:</span>
                <span class="setting-value">Brgy. Banago, Bacolod City</span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Password:</span>
                <span class="setting-value">**********</span>
                <div class="setting-actions">
                    <a href="#">Change</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Delete Account</span>
                <div class="setting-actions">
                    <a href="#" class="delete">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>