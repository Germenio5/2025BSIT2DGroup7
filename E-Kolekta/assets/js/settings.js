// Wait for page to load
document.addEventListener("DOMContentLoaded", () => {
    const profilePhotoInput = document.getElementById("profile_photo");
    const profilePreview = document.getElementById("profilePreview");
    const sidebarProfile = document.querySelector("#user-profile img");

    // Preview selected image in settings page
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    // Show image preview in settings page only
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Show and hide edit forms for each setting
    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const field = btn.dataset.field;
            const form = document.querySelector(`.edit-form[data-field="${field}"]`);
            if (form) {
                form.style.display = form.style.display === "block" ? "none" : "block";
            }
        });
    });

    // Auto hide notification after 3 seconds
    const notifBox = document.querySelector(".notif-box");
    if (notifBox) {
        setTimeout(() => {
            notifBox.style.transition = "opacity 0.3s ease";
            notifBox.style.opacity = 0;
            setTimeout(() => {
                if (notifBox.parentNode) notifBox.parentNode.removeChild(notifBox);
            }, 400);
        }, 3000);
    }
});
