<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <div class="logo">
        <a href="index.php" ><img src="images/E-Kolekta Logo.png" alt="Logo"></a>
        <a href="index.php" class="name">E-Kolekta</a>
    </div>

    <div class="nav-links">
        <a href="about_us.php" class="<?php echo ($current_page == 'about_us.php') ? 'active' : ''; ?>">ABOUT US</a>
        <a href="what_e-waste_we_accept.php"class="<?php echo ($current_page == 'what_e-waste_we_accept.php') ? 'active' : ''; ?>">WHAT E-WASTE WE ACCEPT</a>
    </div>
    
    <div class="login">

    </div>
</nav>