document.getElementById("SigninForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let isValid = true;

    let username = document.getElementById("username").value.trim();
    let fullname = document.getElementById("fullname").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmpassword").value.trim();
    let email = document.getElementById("email").value.trim();
    let number = document.getElementById("number").value.trim();

    let usernameError = document.getElementById("usernameError");
    let fullnameError = document.getElementById("fullnameError");
    let passwordError = document.getElementById("passwordError");
    let confirmPasswordError = document.getElementById("confirmPasswordError");
    let emailError = document.getElementById("emailError");
    let numberError = document.getElementById("numberError");

    [usernameError, fullnameError, passwordError, confirmPasswordError, emailError, numberError].forEach(el => {
        el.style.display = "none";
        el.textContent = "";
    });

    if (username.length < 5) {
        usernameError.textContent = "Username must be at least 5 characters.";
        usernameError.style.display = "block";
        isValid = false;
    }

    if (fullname.length <= 0) {
        fullnameError.textContent = "Invalid Full Name. Please try again.";
        fullnameError.style.display = "block";
        isValid = false;
    }

    if (password.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters.";
        passwordError.style.display = "block";
        isValid = false;
    }

    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.style.display = "block";
        isValid = false;
    }

    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.match(emailPattern)) {
        emailError.textContent = "Enter a valid email address.";
        emailError.style.display = "block";
        isValid = false;
    }

    let phonePattern = /^[0-9]{11,}$/;
    if (!number.match(phonePattern)) {
        numberError.textContent = "Phone Number must be  at least 11 digits.";
        numberError.style.display = "block";
        isValid = false;
    }

    if (isValid) {
        window.location.href = "login.php?registered=success";
    }
});