document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();
    let errorMessage = document.getElementById("errorMessage");

    if(username === "admin" && password === "1234") {
        window.location.href = "dashboard.php";
    } else {
        errorMessage.textContent = "Invalid username or password. Try again.";
        errorMessage.style.display = "block";
    }
});

window.addEventListener("load", function() {
    let message = localStorage.getItem("signupSuccess");
    if (message) {
        let successMessage = document.getElementById("successMessage");
        successMessage.textContent = message;
        successMessage.style.display = "block";
        localStorage.removeItem("signupSuccess");
    }
});