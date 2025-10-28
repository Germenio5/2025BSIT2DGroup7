<?php
session_start();
require_once "database.php";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$message = "";
$messageType = "";

// Get user info
$stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Redirect with message
function redirect_with_message($msgType, $msg) {
    $url = "settings.php";
    $params = [
        'mtype' => $msgType,
        'msg' => rawurlencode($msg)
    ];
    header("Location: $url?" . http_build_query($params));
    exit;
}

// Display message
if (isset($_GET['mtype']) && isset($_GET['msg'])) {
    $messageType = $_GET['mtype'];
    $message = rawurldecode($_GET['msg']);
}

// Upload profile photo (stored as BLOB in database)
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['upload_new'])) {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {

        $fileTmp = $_FILES['profile_photo']['tmp_name'];
        $fileType = mime_content_type($fileTmp);

        // Allowed image types
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowed)) {
            redirect_with_message("error", "Invalid image type. Allowed: jpg, jpeg, png, gif.");
        }

        // Read image as binary data
        $imageData = file_get_contents($fileTmp);

        // Store image directly in database
        $stmt = $conn->prepare("UPDATE accounts SET profile_image = ? WHERE username = ?");
        $null = NULL;
        $stmt->bind_param("bs", $null, $username);
        $stmt->send_long_data(0, $imageData);
        $stmt->execute();
        $stmt->close();

        // Save base64 version in session for sidebar display
        $_SESSION['profileImage'] = base64_encode($imageData);

        redirect_with_message("success", "Profile photo updated successfully!");
    } else {
        redirect_with_message("error", "No file uploaded or upload error.");
    }
}

// Editable fields
$allowedFields = [
    "username" => "username",
    "fullname" => "full_name",
    "email" => "email_address",
    "number" => "phone_number"
];

// Update user info
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];
    if (!array_key_exists($field, $allowedFields)) {
        redirect_with_message("error", "Invalid field.");
    }

    $value = trim($_POST[$field] ?? '');
    if ($value === '') {
        redirect_with_message("error", "Please enter a valid $field.");
    }

    // Validate inputs
    if ($field === 'username' && strlen($value) < 5) {
        redirect_with_message("error", "Username must be at least 5 characters.");
    }
    if ($field === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        redirect_with_message("error", "Enter a valid email address.");
    }
    if ($field === 'number' && !preg_match("/^[0-9]{11,}$/", $value)) {
        redirect_with_message("error", "Phone number must be at least 11 digits.");
    }

    $column = $allowedFields[$field];

    // Check duplicates
    if ($field === 'username' || $field === 'email') {
        $checkCol = $field === 'username' ? 'username' : 'email_address';
        $stmt = $conn->prepare("SELECT id FROM accounts WHERE $checkCol = ? AND username <> ?");
        $stmt->bind_param("ss", $value, $username);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $stmt->close();
            redirect_with_message("error", ucfirst($field) . " already exists.");
        }
        $stmt->close();
    }

    // Update field
    $stmt = $conn->prepare("UPDATE accounts SET $column = ? WHERE username = ?");
    $stmt->bind_param("ss", $value, $username);
    if ($stmt->execute()) {
        $stmt->close();
        if ($field === 'username') {
            $_SESSION['username'] = $value;
            $username = $value;
        }
        redirect_with_message("success", ucfirst($field) . " updated successfully!");
    } else {
        $stmt->close();
        redirect_with_message("error", "Error updating " . $field . ".");
    }
}

// Change password
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = $conn->prepare("SELECT password FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPass);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current, $hashedPass)) {
        redirect_with_message("error", "Incorrect current password.");
    }
    if ($new !== $confirm || strlen($new) < 8) {
        redirect_with_message("error", "Passwords do not match or too short (min 8).");
    }

    $newHashed = password_hash($new, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE accounts SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $newHashed, $username);
    if ($stmt->execute()) {
        $stmt->close();
        redirect_with_message("success", "Password changed successfully!");
    } else {
        $stmt->close();
        redirect_with_message("error", "Error updating password.");
    }
}

// Delete account
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_account'])) {
    $stmt = $conn->prepare("DELETE FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $stmt->close();
        session_destroy();
        header("Location: login.php?deleted=1");
        exit;
    } else {
        $stmt->close();
        redirect_with_message("error", "Error deleting account.");
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
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
            <div class="notif-box <?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="settings-box">
            <div class="profile-section">
                <div class="profile-pic">
                    <?php
                    // Display profile photo from database (BLOB) or default
                    $defaultImage = "images/user_icon.png";
                    if (!empty($user['profile_image'])) {
                        $profileImage = 'data:image/jpeg;base64,' . base64_encode($user['profile_image']);
                    } elseif (!empty($_SESSION['profileImage'])) {
                        $profileImage = 'data:image/jpeg;base64,' . $_SESSION['profileImage'];
                    } else {
                        $profileImage = $defaultImage;
                    }
                    ?>
                    <img id="profilePreview" src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture">
                </div>
            </div>

            <!-- Upload new profile photo -->
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
                "username" => $user['username'] ?? '',
                "fullname" => $user['full_name'] ?? '',
                "email" => $user['email_address'] ?? '',
                "number" => $user['phone_number'] ?? ''
            ];
            foreach ($fields as $key => $val): ?>
                <div class="setting-item">
                    <div class="setting-row">
                        <span class="setting-label"><?= ucfirst($key) ?>:</span>
                        <span class="setting-value"><?= htmlspecialchars($val) ?></span>
                        <button type="button" class="edit-btn" data-field="<?= $key ?>">Change</button>
                    </div>
                    <form method="POST" class="edit-form" data-field="<?= $key ?>" style="display:none;">
                        <input type="<?= $key === 'email' ? 'email' : 'text' ?>" name="<?= $key ?>" placeholder="Enter new <?= $key ?>">
                        <button type="submit" name="update_field" value="<?= $key ?>">Save</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <!-- Change password -->
            <div class="setting-item">
                <div class="setting-row">
                    <span class="setting-label">Change password</span>
                    <button type="button" class="edit-btn" data-field="password">Change</button>
                </div>
                <form method="POST" class="edit-form" data-field="password" style="display:none;">
                    <input type="password" name="current_password" placeholder="Current password" required>
                    <input type="password" name="new_password" placeholder="New password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm password" required>
                    <button type="submit" name="change_password">Save</button>
                </form>
            </div>

            <!-- Delete account -->
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