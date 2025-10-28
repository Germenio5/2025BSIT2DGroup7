<?php
require_once "database.php";

$current_page = basename($_SERVER['PHP_SELF']);
$username = $_SESSION['username'] ?? null;
$defaultImage = "images/user_icon.png";
$profileImage = $defaultImage;

if ($username) {
    // Get profile image from the database (stored as BLOB)
    $stmt = $conn->prepare("SELECT profile_image FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbImage);
        $stmt->fetch();

        if (!empty($dbImage)) {
            // Convert BLOB to base64 image
            $profileImage = 'data:image/jpeg;base64,' . base64_encode($dbImage);
        } elseif (!empty($_SESSION['profileImage'])) {
            // Use cached session image if available
            $profileImage = 'data:image/jpeg;base64,' . $_SESSION['profileImage'];
        }
    }

    $stmt->close();
}
?>

<div class="sidebar" id="sidebar">
    <a href="dashboard.php" id="user-profile" class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <img src="<?= htmlspecialchars($profileImage) ?>" alt="User Icon">
        <span class="username"><?= htmlspecialchars($_SESSION['username'] ?? $_SESSION['registeredUser'] ?? '') ?></span>
    </a>
    <a href="schedule.php" id="icon" class="<?= ($current_page == 'schedule.php') ? 'active' : ''; ?>"> 
        <img src="images/schedule_icon.png" alt="Schedule Icon"><div>SCHEDULE</div>
    </a>
    <a href="rewards.php" id="icon" class="<?= ($current_page == 'rewards.php') ? 'active' : ''; ?>"> 
        <img src="images/reward_icon.png" alt="Rewards Icon"><div>REWARDS</div>
    </a>
    <a href="view_hub.php" id="icon" class="<?= ($current_page == 'view_hub.php') ? 'active' : ''; ?>"> 
        <img src="images/view_hub_icon.png" alt="View Hub Icon"><div>VIEW HUB</div>
    </a>
    <a href="settings.php" id="icon" class="<?= ($current_page == 'settings.php') ? 'active' : ''; ?>"> 
        <img src="images/setting_icon.png" alt="Settings Icon"><div>SETTINGS</div>
    </a>
    <a href="logout.php" id="logout" class="logout">
        <img src="images/logout.png" alt="Logout Icon"><div>LOG OUT</div>
    </a>
</div>