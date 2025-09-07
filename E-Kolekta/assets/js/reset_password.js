document.getElementById("resetForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let email = document.getElementById("email").value.trim();
    let resetMessage = document.getElementById("resetMessage");

    if(email == /^[^ ]+@[^ ]+\.[a-z]{2,3}$/) {
        resetMessage.style.display = "block";
        resetMessage.style.color = "lime";
        resetMessage.textContent = "A reset link has been sent to your email. It will expire in 5 minutes.";
        document.getElementById("resetForm").reset();
    } else {
        resetMessage.style.display = "block";
        resetMessage.style.color = "red";
        resetMessage.textContent = "Please enter a valid email.";
    }
});