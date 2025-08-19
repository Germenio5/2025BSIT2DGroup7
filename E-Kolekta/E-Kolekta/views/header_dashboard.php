<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <div class="logo">
        <a href="dashboard.php" ><img src="images/E-Kolekta Logo.png" alt="Logo"></a>
        <a href="dashboard.php" class="name">E-Kolekta</a>
    </div>

    <div class="nav-links">
        <a href="dashboard_about_us.php" class="<?php echo ($current_page == 'dashboard_about_us.php') ? 'active' : ''; ?>">ABOUT US</a>
        <a href="dashboard_what_e-waste_we_accept.php"class="<?php echo ($current_page == 'dashboard_what_e-waste_we_accept.php') ? 'active' : ''; ?>">WHAT E-WASTE WE ACCEPT</a>
    </div>
    
    <div class="login">
        <a href="index.php">LOG OUT</a>
    </div>
</nav>