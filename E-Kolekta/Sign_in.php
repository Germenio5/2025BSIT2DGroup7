<?php
session_start();

$errors = [];
$username = $_POST['username'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$password = $_POST['password'] ?? '';
$confirmpassword = $_POST['confirmpassword'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (strlen($username) < 5) {
        $errors['username'] = "Username must be at least 5 characters.";
    }

    if (empty($fullname)) {
        $errors['fullname'] = "Please enter your fullname.";
    }

    if (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters.";
    }

    if ($password !== $confirmpassword) {
        $errors['confirmpassword'] = "Passwords do not match.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter a valid email address.";
    }

    if (!preg_match("/^[0-9]{11,}$/", $number)) {
        $errors['number'] = "Phone Number must be at least 11 digits.";
    }

    if (empty($errors)) {
        $_SESSION['registeredUser'] = $username;
        $_SESSION['registeredPass'] = password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
        $_SESSION['number'] = $number;

        header("Location: login.php?registered=success");
        exit;
    }
}
?>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN IN</title>
    <link rel="stylesheet" href="assets/css/login.css"/>
</head>
<body>
    <?php require "views/header_login.php"; ?>
    <section class="hero">
    <div class="overlay"></div>
    <div class="Signin-container">
        <div class="Signin-box">
            <h2>SIGN IN</h2>
            <form id="SigninForm" method="POST" action="sign_in.php">
                <input type="text" name="username" id="username" placeholder="Username" required value="<?= htmlspecialchars($username) ?>">
                <p class="error-message" id="usernameError"><?= $errors['username'] ?? '' ?></p>

                <input type="text" name="fullname" id="fullname" placeholder="Full Name" required value="<?= htmlspecialchars($fullname) ?>">
                <p class="error-message" id="fullnameError"><?= $errors['fullname'] ?? '' ?></p>

                <input type="password" name="password" id="password" placeholder="Password" required>
                <p class="error-message" id="passwordError"><?= $errors['password'] ?? '' ?></p>

                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                <p class="error-message" id="confirmPasswordError"><?= $errors['confirmpassword'] ?? '' ?></p>

                <input type="text" name="email" id="email" placeholder="Email Address" required value="<?= htmlspecialchars($email) ?>">
                <p class="error-message" id="emailError"><?= $errors['email'] ?? '' ?></p>

                <input type="text" name="number" id="number" placeholder="Phone Number" required value="<?= htmlspecialchars($number) ?>">
                <p class="error-message" id="numberError"><?= $errors['number'] ?? '' ?></p>

                <button type="submit" class="signin-btn">SIGN IN</button>
            </form>

            <div class="links">
                Already have Account? <a href="login.php">Log in here</a>
            </div>
        </div>
    </div>
</section>
</body>
</html>