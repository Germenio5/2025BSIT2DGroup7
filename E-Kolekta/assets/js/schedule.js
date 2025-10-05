document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("optionForm");
    const dateField = document.getElementById("date");
    const dateError = document.getElementById("dateError");
    const modal = document.getElementById("confirmationModal");
    const confirmationDetails = document.getElementById("confirmationDetails");
    const confirmBtn = document.getElementById("confirmBtn");
    const cancelBtn = document.getElementById("cancelBtn");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        let isValid = true;

        document.querySelectorAll(".error-message").forEach(el => {
            if (el.id !== "dateError") el.remove();
        });

        const requiredFields = ["option", "date", "time", "ewaste-type", "condition"];
        const option = document.getElementById("option").value;

        if (option === "PICK-UP") {
            requiredFields.push("address");
        } else if (option === "DROP-OFF") {
            requiredFields.push("dropoff");
        }

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field || !field.value.trim()) {
                isValid = false;
                if (fieldId !== "date") insertError(field, "This field is required.");
            }
        });

        if (dateField.value) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selectedDate = new Date(dateField.value);

            if (selectedDate < today) {
                isValid = false;
                dateError.textContent = "Invalid date. Date cannot be in the past.";
                dateError.style.display = "block";
            } else {
                dateError.textContent = "";
                dateError.style.display = "none";
            }
        }

        if (isValid) {
            const summaryHTML = `
                <div id="confirm_text">CONFIRM YOUR SCHEDULE</div>
                <hr>
                <p><strong>Collection Type:</strong> ${option}</p>
                <p><strong>Date:</strong> ${dateField.value}</p>
                <p><strong>Time:</strong> ${document.getElementById("time").value}</p>
                <p><strong>E-Waste Type:</strong> ${document.getElementById("ewaste-type").value}</p>
                <p><strong>Condition:</strong> ${document.getElementById("condition").value}</p>
                ${option === "PICK-UP"
                    ? `<p><strong>Address:</strong> ${document.getElementById("address").value}</p>`
                    : `<p><strong>Drop-off Location:</strong> ${document.getElementById("dropoff").value}</p>`
                }
            `;
            confirmationDetails.innerHTML = summaryHTML;
            modal.classList.add("show");

            confirmBtn.onclick = () => {
                modal.classList.remove("show");
                form.submit();
            };

            cancelBtn.onclick = () => {
                modal.classList.remove("show");
            };
        }
    });

    function insertError(field, message) {
        const error = document.createElement("div");
        error.classList.add("error-message");
        error.style.color = "red";
        error.style.fontSize = "14px";
        error.style.marginTop = "5px";
        error.textContent = message;
        field.insertAdjacentElement("afterend", error);
    }

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
            document.getElementById("address").required = false;
            document.getElementById("dropoff").required = false;
        }
    });
});
