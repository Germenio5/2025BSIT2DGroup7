document.addEventListener("DOMContentLoaded", () => {
    const profilePhotoInput = document.getElementById("profile_photo");
    const profilePreview = document.getElementById("profilePreview");
    const sidebarProfile = document.querySelector("#user-profile img");

    if (profilePhotoInput) {
        profilePhotoInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    profilePreview.src = e.target.result;
                    if (sidebarProfile) sidebarProfile.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const field = btn.dataset.field;
            const form = document.querySelector(`.edit-form[data-field="${field}"]`);
            if (form) {
                form.style.display = form.style.display === "block" ? "none" : "block";
            }
        });
    });

    const notifBox = document.querySelector(".notif-box");
    if (notifBox) {
        setTimeout(() => {
            notifBox.style.transition = "opacity 0.3s ease";
            notifBox.style.opacity = 0;
            setTimeout(() => { if (notifBox.parentNode) notifBox.parentNode.removeChild(notifBox); }, 400);
        }, 3000);
    }
});
