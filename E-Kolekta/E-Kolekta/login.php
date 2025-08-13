<html lang="en">
<head>
    <title>What E-Waste we Accept</title>
    <link rel="stylesheet" href="assets/login.css"/>
</head>
<body>
    <?php require "views/header.php"; ?>
    <section class="hero">
        <div class="overlay"></div>
        <div class="login-container">
        <div class="login-box">
        <h2>LOGIN</h2>
        <form id="loginForm">
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>

            <div class="remember">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="login-btn" href=>LOGIN</button>
        </form>

        <div class="links">
            Don’t Have Account? <a href="#">Sign in Here</a><br>
            Forgot your password? <a href="#">Reset it.</a>
        </div>
        </div>
        </div>
    </section>
    <?php require "views/footer.php"; ?>
</body>
<script src="login.js"></script>
</html>