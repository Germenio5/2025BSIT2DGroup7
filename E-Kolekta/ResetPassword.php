<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What E-Waste we Accept</title>
    <link rel="stylesheet" href="assets/login.css"/>
</head>
<body>
    <?php require "views/header_login.php"; ?>
    <section class="hero">
        <div class="overlay"></div>
        <div class="reset-container">
        <div class="reset-box">
        <h2>RESET PASSWORD</h2>
        <form id="resetForm">
            <p>Enter your email and we'll send a link to reset your password.</p>
            <input type="text" id="email" placeholder="Email Address" required>
            <button type="submit" class="submit-btn" href=>SUBMIT</button>
        </form>

        </div>
        </div>
    </section>
    <?php require "views/footer.php"; ?>
</body>
<script src="assets/login.js"></script>
</html>