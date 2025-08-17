document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    if(username === "admin" && password === "1234") {
        window.location.href = "dashboard.php";
    } else {
        alert("Invalid username or password.");
    }
});