<?php
session_start();
require_once "database.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if user exists in the "accounts" table
    $sql = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email_address'] = $user['email_address'];
            $_SESSION['phone_number'] = $user['phone_number'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $sql->close();
}
?>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="assets/css/login.css"/>
</head>
<body>
    <?php require "views/header_login.php"; ?>
    <section class="hero">
        <div class="overlay"></div>
        <div class="login-container">
            <div class="login-box">
                <h2>LOGIN</h2>
                <form id="loginForm" method="POST" action="login.php">
                    <?php if(isset($_GET['registered']) && $_GET['registered'] == "success"): ?>
                        <div style="color: #34f230; text-align:center; font-size:14px; margin:5px;">
                            Account created successfully! Please log in.
                        </div>
                    <?php endif; ?>

                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>

                    <?php if (!empty($error)): ?>
                        <div style="color: red; text-align:left; font-size:14px; margin:5px 0 5px 5px;">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="remember">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>

                    <button type="submit" class="login-btn">LOGIN</button>
                </form>

                <div class="links">
                    Don’t Have Account? <a href="sign_in.php">Sign in here</a><br>
                    Forgot your password? <a href="reset_password.php">Reset it.</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
