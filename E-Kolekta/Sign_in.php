<?php
session_start();
require_once "database.php";

$errors = [];
$username = $_POST['username'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$password = $_POST['password'] ?? '';
$confirmpassword = $_POST['confirmpassword'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';

// Run code only when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Basic input validation
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

    // Check if username or email already exists in the database
    if (empty($errors)) {
        $sql = $conn->prepare("SELECT * FROM accounts WHERE username = ? OR email_address = ?");
        $sql->bind_param("ss", $username, $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $errors['username'] = "Username or Email already exists.";
        }
        $sql->close();
    }

    // If no errors, save new account to database
    if (empty($errors)) {
        // Hash the password before saving for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user info into 'accounts' table
        $sql = $conn->prepare("INSERT INTO accounts (username, full_name, password, email_address, phone_number) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssss", $username, $fullname, $hashedPassword, $email, $number);

        if ($sql->execute()) {
            header("Location: login.php?registered=success");
            exit;
        } 
        else {
            $errors['database'] = "Error saving your data. Please try again.";
        }

        $sql->close();
    }
}
?>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
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
                <p class="error-message"><?= $errors['username'] ?? '' ?></p>

                <input type="text" name="fullname" id="fullname" placeholder="Full Name" required value="<?= htmlspecialchars($fullname) ?>">
                <p class="error-message"><?= $errors['fullname'] ?? '' ?></p>

                <input type="password" name="password" id="password" placeholder="Password" required>
                <p class="error-message"><?= $errors['password'] ?? '' ?></p>

                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                <p class="error-message"><?= $errors['confirmpassword'] ?? '' ?></p>

                <input type="text" name="email" id="email" placeholder="Email Address" required value="<?= htmlspecialchars($email) ?>">
                <p class="error-message"><?= $errors['email'] ?? '' ?></p>

                <input type="text" name="number" id="number" placeholder="Phone Number" required value="<?= htmlspecialchars($number) ?>">
                <p class="error-message"><?= $errors['number'] ?? '' ?></p>

                <?php if (isset($errors['database'])): ?>
                    <p class="error-message"><?= $errors['database'] ?></p>
                <?php endif; ?>

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