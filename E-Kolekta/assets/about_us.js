document.querySelectorAll(".faq-item").forEach(item => {
    let question = item.querySelector(".faq-question");
    let answer = item.querySelector(".faq-answer");
    let plus = item.querySelector(".faq-question span:last-child");

    question.addEventListener("click", () => {
        answer.classList.toggle("show");
        plus.textContent = answer.classList.contains("show") ? "−" : "+";
    });
});