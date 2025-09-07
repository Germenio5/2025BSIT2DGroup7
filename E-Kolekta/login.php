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
        <div class="login-container">
        <div class="login-box">
        <h2>LOGIN</h2>
        <form id="loginForm">
            <?php if(isset($_GET['registered']) && $_GET['registered'] == "success"): ?>
                <p style="color: #34f230; text-align:center; font-size:14px;">Account created successfully! Please log in.</p>
            <?php endif; ?>
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>

            <p id="errorMessage" class="error-message" style="display: none;"></p>

            <div class="remember">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="login-btn" href=>LOGIN</button>
        </form>

        <div class="links">
            Don’t Have Account? <a href="sign_in.php">Sign in here</a><br>
            Forgot your password? <a href="reset_password.php">Reset it.</a>
        </div>
        </div>
        </div>
    </section>
</body>
<script src="assets/js/login.js"></script>
</html>