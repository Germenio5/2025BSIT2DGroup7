<?php
session_start();
require_once "database.php";

// Make sure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$message = "";
$messageType = "";

// Fetch current user info from DB (always fetch on every page load)
$stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Helper: redirect back with query param to show a message (prevents form re-submission)
function redirect_with_message($msgType, $msg) {
    $url = "settings.php";
    $params = [
        'mtype' => $msgType,
        'msg' => rawurlencode($msg)
    ];
    header("Location: $url?" . http_build_query($params));
    exit;
}

// If redirected back with message, populate $message & $messageType
if (isset($_GET['mtype']) && isset($_GET['msg'])) {
    $messageType = $_GET['mtype'];
    $message = rawurldecode($_GET['msg']);
}

// Handle profile photo upload
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['upload_new'])) {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) {
            redirect_with_message("error", "Invalid image type. Allowed: jpg, png, gif.");
        }
        $fileName = "profile_" . $username . "_" . time() . "." . $ext;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {

            // Update session and redirect so page reloads and shows new image
            $_SESSION['profileImage'] = $targetFile;
            redirect_with_message("success", "Profile photo updated successfully!");
        } else {
            redirect_with_message("error", "Error uploading image.");
        }
    } else {
        redirect_with_message("error", "No file uploaded or upload error.");
    }
}

// Allowed fields mapping (form name => DB column)
$allowedFields = [
    "username" => "username",
    "fullname" => "full_name",
    "email" => "email_address",
    "number" => "phone_number"
];

// Handle updating fields (username/fullname/email/number)
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];
    if (!array_key_exists($field, $allowedFields)) {
        redirect_with_message("error", "Invalid field.");
    }

    $value = trim($_POST[$field] ?? '');
    if ($value === '') {
        redirect_with_message("error", "Please enter a valid $field.");
    }

    // Basic validation
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

    // Check duplicates for username/email
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

    // Perform update
    $stmt = $conn->prepare("UPDATE accounts SET $column = ? WHERE username = ?");
    $stmt->bind_param("ss", $value, $username);
    if ($stmt->execute()) {
        $stmt->close();
        // If username changed, update session username so next fetch uses new username
        if ($field === 'username') {
            $_SESSION['username'] = $value;
            $username = $value;
        }
        // Also update relevant session variables for display (optional)
        if ($field === 'fullname') $_SESSION['fullname'] = $value;
        if ($field === 'email') $_SESSION['email'] = $value;
        if ($field === 'number') $_SESSION['number'] = $value;

        redirect_with_message("success", ucfirst($field) . " updated successfully!");
    } else {
        $stmt->close();
        redirect_with_message("error", "Error updating " . $field . ".");
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Fetch hashed password from DB
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

// Handle account deletion
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

        <?php if (!empty($message) || (!empty($_GET['mtype']) && !empty($_GET['msg']))): 
            // If redirected, we already populated $message from GET above
        ?>
            <div class="notif-box <?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="settings-box">
            <div class="profile-section">
                <div class="profile-pic">
                    <?php $profileImage = $_SESSION['profileImage'] ?? "images/user_icon.png"; ?>
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
            // Use fresh $user fetched at top
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