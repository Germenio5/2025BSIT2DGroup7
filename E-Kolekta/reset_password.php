<?php
session_start();
$resetMessage = "";
$resetColor = "red";
$email = $_POST['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $resetMessage = "A reset link has been sent to your email. It will expire in 5 minutes.";
        $resetColor = "lime";
    } else {
        $resetMessage = "Please enter a valid email.";
        $resetColor = "red";
    }
}
?>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/login.css"/>
</head>
<body>
    <?php require "views/header_login.php"; ?>
    <section class="hero">
        <div class="overlay"></div>
        <div class="reset-container">
        <div class="reset-box">
        <h2>RESET PASSWORD</h2>
        <form id="resetForm" method="POST" action="reset_password.php">
            <div id="resetpassword_text">Enter your email and we'll send a link to reset your password.</div>
            
            <input type="text" name="email" id="email" placeholder="Email Address" required value="<?= htmlspecialchars($email) ?>">
            
            <?php if (!empty($resetMessage)): ?>
                <div id="resetMessage" style="display:block; margin-top:5px; font-size:14px; color:<?= $resetColor ?>;"><?= $resetMessage ?></div>
            <?php else: ?>
                <div id="resetMessage" style="display:none; margin-top:5px; font-size:14px;"></div>
            <?php endif; ?>

            <button type="submit" class="submit-btn">SUBMIT</button>

            <div class="reset_password_links">
                 <a href="login.php">Return to Login</a>
            </div>
        </form>
        </div>
        </div>
    </section>
</body>
</html>
