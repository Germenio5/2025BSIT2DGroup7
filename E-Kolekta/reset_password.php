<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What E-Waste we Accept</title>
    <link rel="stylesheet" href="assets/css/login.css"/>
</head>
<body>
    <?php require "views/header_login.php"; ?>
    <section class="hero">
        <div class="overlay"></div>
        <div class="reset-container">
        <div class="reset-box">
        <h2>RESET PASSWORD</h2>
        <form id="resetForm">
            <div id="resetpassword_text">Enter your email and we'll send a link to reset your password.</div>
            <input type="text" id="email" placeholder="Email Address" required>
            <p id="resetMessage"></p>
            <button type="submit" class="submit-btn" href=>SUBMIT</button>

            <div class="reset_password_links">
                 <a href="login.php">Return to Login</a>
            </div>
        </form>
        </div>
        </div>
    </section>
</body>
<script src="assets/js/reset_password.js"></script>
</html>