<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">
    <a href="dashboard.php" id="user-profile" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <img src="images/user_icon.png" alt="User Icon">
        <span class="username">username</span>
    </a>
    <a href="schedule.php" id="icon" class="<?php echo ($current_page == 'schedule.php') ? 'active' : ''; ?>"> <img src="images/schedule_icon.png" alt="User Photo"><div>SCHEDULE</div></a>
    <a href="rewards.php" id="icon" class="<?php echo ($current_page == 'rewards.php') ? 'active' : ''; ?>"> <img src="images/reward_icon.png" alt="User Photo"><div>REWARDS</div></a>
    <a href="view_hub.php" id="icon" class="<?php echo ($current_page == 'view_hub.php') ? 'active' : ''; ?>"> <img src="images/view_hub_icon.png" alt="User Photo"><div>VIEW HUB</div></a>
    <a href="settings.php" id="icon" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"> <img src="images/setting_icon.png" alt="User Photo"><div>SETTINGS</div></a>
    <a href="index.php" id="logout" class="logout"><img src="images/logout.png" alt="User Photo"><div>LOG OUT</div></a>
</div>