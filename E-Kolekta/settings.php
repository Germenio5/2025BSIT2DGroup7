<?php
session_start();

if (!isset($_SESSION['registeredUser']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$profileImage = $_SESSION['profileImage'] ?? "images/user_icon.png";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $originalName = pathinfo($_FILES['profile_photo']['name'], PATHINFO_FILENAME);
    $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
    $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
    $fileName = $safeName . '_' . time() . '.' . $ext;
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
        $_SESSION['profileImage'] = $targetFile;
        $profileImage = $targetFile;
    }
}
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
        <div id="settings_text">SETTINGS</div>

        <div class="settings-box">
            <div class="profile-section">
                <div class="profile-pic">
                    <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture">
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="setting-item">
                    <span class="setting-label">Change Profile Photo</span>
                    <div class="setting-actions">
                        <input type="file" name="profile_photo" id="profile_photo">
                        <label for="profile_photo" class="file-label">Choose File</label>
                        <button type="submit" class="change-photo">Upload New</button>
                    </div>
                </div>
            </form>

            <div class="setting-item">
                <span class="setting-label">Full Name:</span>
                <span class="setting-value"><?= htmlspecialchars($_SESSION['fullname'] ?? ($_SESSION['registeredUser'] ?? '')) ?></span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Email:</span>
                <span class="setting-value"><?= htmlspecialchars($_SESSION['email'] ?? '') ?></span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Phone Number:</span>
                <span class="setting-value"><?= htmlspecialchars($_SESSION['number'] ?? '') ?></span>
                <div class="setting-actions">
                    <a href="#">Edit</a>
                </div>
            </div>

            <div class="setting-item">
                <span class="setting-label">Change Password</span>
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
