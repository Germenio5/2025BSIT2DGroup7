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
    <div class="Signin-container">
        <div class="Signin-box">
            <h2>SIGN IN</h2>
            <form id="SigninForm">
                <input type="text" id="username" placeholder="Username" required>
                <p class="error-message" id="usernameError"></p>

                <input type="text" id="fullname" placeholder="Full Name" required>
                <p class="error-message" id="fullnameError"></p>

                <input type="password" id="password" placeholder="Password" required>
                <p class="error-message" id="passwordError"></p>

                <input type="password" id="confirmpassword" placeholder="Confirm Password" required>
                <p class="error-message" id="confirmPasswordError"></p>

                <input type="text" id="email" placeholder="Email Address" required>
                <p class="error-message" id="emailError"></p>

                <input type="text" id="number" placeholder="Phone Number" required>
                <p class="error-message" id="numberError"></p>

                <button type="submit" class="signin-btn">SIGN IN</button>
            </form>

            <div class="links">
                Already have Account? <a href="login.php">Log in here</a>
            </div>
        </div>
    </div>
</section>
</body>
<script src="assets/js/sign_in.js"></script>
</html>