<?php
session_start();

if (!isset($_SESSION['registeredUser']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$profileImage = $_SESSION['profileImage'] ?? "images/user_icon.png";
$message = "";
$messageType = "success";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['upload_new'])) {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        $originalName = pathinfo($_FILES['profile_photo']['name'], PATHINFO_FILENAME);
        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $fileName = $safeName . '_' . time() . '.' . $ext;
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
            $_SESSION['profileImage'] = $targetFile;
            $profileImage = $targetFile;
            $message = "Profile photo updated successfully!";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];
    $value = trim($_POST[$field]) ?? '';
    if (!empty($value)) {
        $_SESSION[$field] = $value;
        $message = ucfirst($field) . " updated successfully!";
    } else {
        $message = "Please enter a valid " . $field . ".";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (password_verify($current, $_SESSION['registeredPass'])) {
        if ($new === $confirm && strlen($new) >= 8) {
            $_SESSION['registeredPass'] = password_hash($new, PASSWORD_DEFAULT);
            $message = "Password changed successfully!";
        } else {
            $message = "Passwords do not match or too short!";
            $messageType = "error";
        }
    } else {
        $message = "Incorrect current password!";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_account'])) {
    session_destroy();
    header("Location: login.php?deleted=1");
    exit;
}
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="assets/css/dashboard.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" href="assets/css/settings.css"/>
</head>
<body>
<div class="content-wrapper">
    <?php include "views/sidebar.php"; ?>

    <div class="main-content">
        <div id="settings_text">SETTINGS</div>

        <?php if (!empty($message)): ?>
            <div class="notif-box <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="settings-box">
            <div class="profile-section">
                <div class="profile-pic">
                    <img id="profilePreview" src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture">
                </div>
            </div>

            <form id="profile_form" method="POST" enctype="multipart/form-data">
                <div class="setting-item">
                    <div class="setting-row">
                        <span class="setting-label">Change Profile Photo</span>
                        <div class="setting-actions">
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                            <label for="profile_photo" class="file-label">Choose File</label>
                            <button type="submit" name="upload_new" class="change-photo">Upload New</button>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            $fields = [
                "username" => $_SESSION['username'] ?? $_SESSION['registeredUser'],
                "fullname" => $_SESSION['fullname'] ?? '',
                "email" => $_SESSION['email'] ?? '',
                "number" => $_SESSION['number'] ?? ''
            ];
            foreach ($fields as $key => $val): ?>
                <div class="setting-item">
                    <div class="setting-row">
                        <span class="setting-label"><?= ucfirst($key) ?>:</span>
                        <span class="setting-value"><?= htmlspecialchars($val) ?></span>
                        <button type="button" class="edit-btn" data-field="<?= $key ?>">Change</button>
                    </div>
                    <form method="POST" class="edit-form" data-field="<?= $key ?>">
                        <input type="<?= $key === 'email' ? 'email' : 'text' ?>" name="<?= $key ?>" placeholder="Enter new <?= $key ?>">
                        <button type="submit" name="update_field" value="<?= $key ?>">Save</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="setting-item">
                <div class="setting-row">
                    <span class="setting-label">Password:</span>
                    <span class="setting-value">********</span>
                    <button type="button" class="edit-btn" data-field="password">Change</button>
                </div>
                <form method="POST" class="edit-form" data-field="password">
                    <input type="password" name="current_password" placeholder="Current password" required>
                    <input type="password" name="new_password" placeholder="New password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm password" required>
                    <button type="submit" name="change_password">Save</button>
                </form>
            </div>

            <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                <div class="setting-item">
                    <div class="setting-row">
                        <span class="setting-label">Delete Account</span>
                        <button type="submit" name="delete_account" class="delete">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/settings.js"></script>
</body>
</html>
