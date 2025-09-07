document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("optionForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        let isValid = true;

        document.querySelectorAll(".error-message").forEach(el => el.style.display = "none");

        const requiredFields = ["option", "date", "time", "address", "ewaste-type", "condition"];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                isValid = false;
                showError(field, "This field is required.");
            }
        });

        if (isValid) {
            alert("✅ Schedule submitted successfully!");
            form.submit();
        }
    });

    function showError(field, message) {
        let error = field.nextElementSibling;
        if (!error || !error.classList.contains("error-message")) {
            error = document.createElement("div");
            error.classList.add("error-message");
            field.parentNode.appendChild(error);
        }
        error.textContent = message;
        error.style.display = "block";
    }
});

document.getElementById("option").addEventListener("change", function () {
    const pickupAddress = document.getElementById("pickupAddress");
    const dropoffLocations = document.getElementById("dropoffLocations");

    if (this.value === "PICK-UP") {
        pickupAddress.style.display = "block";
        dropoffLocations.style.display = "none";
        document.getElementById("address").required = true;
        document.getElementById("dropoff").required = false;
    } else if (this.value === "DROP-OFF") {
        pickupAddress.style.display = "none";
        dropoffLocations.style.display = "block";
        document.getElementById("address").required = false;
        document.getElementById("dropoff").required = true;
    } else {
        pickupAddress.style.display = "none";
        dropoffLocations.style.display = "none";
    }
});