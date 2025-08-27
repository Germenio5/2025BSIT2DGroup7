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
        <div class="Signin-container">
        <div class="Signin-box">
        <h2>SIGN IN</h2>
        <form id="SigninForm">
            <input type="text" id="username" placeholder="Username" required>
            <input type="text" id="fullname" placeholder="Full Name" required>
            <input type="text" id="password" placeholder="Password" required>
            <input type="text" id="confirmpassword" placeholder="Confirm Password" required>
            <input type="text" id="email" placeholder="Email Address" required>
            <input type="text" id="number" placeholder="Phone Number" required>

           

            <button type="submit" class="signin-btn" href=>SIGN IN</button>
        </form>

        </div>
        </div>
    </section>
    <?php require "views/footer.php"; ?>
</body>
<script src="assets/login.js"></script>
</html>