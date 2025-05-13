document.addEventListener("DOMContentLoaded", function () {
    const answers = document.querySelectorAll(".answer-btn");
    let correctAnswer = 2; // Example: Paris is the correct answer

    answers.forEach(answer => {
        answer.addEventListener("click", function () {
            if (parseInt(this.dataset.answer) === correctAnswer) {
                this.classList.add("correct-answer"); // Apply Green Styling
            } else {
                this.classList.add("wrong-answer"); // Apply Red Styling & Make Bigger
                document.querySelector(".answer-btn[data-answer='2']").classList.add("correct-answer"); // Show correct one
            }

            // Disable further clicks
            answers.forEach(a => a.classList.add("disabled"));
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const badgeModal = document.getElementById("badgeModal");
    const closeBadgeButton = document.getElementById("closeBadge");
    const answerButtons = document.querySelectorAll(".answer-btn");

    let correctAnswers = 0;
    let totalQuestions = 1; // Change this based on the number of questions
    let answered = false;

    // Handle answer selection
    answerButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (answered) return; // Prevent multiple clicks
            
            answered = true; // Mark question as answered

            if (this.classList.contains("correct")) {
                correctAnswers++;
            }

            // Check if quiz is finished
            if (correctAnswers === totalQuestions) {
                setTimeout(() => {
                    badgeModal.style.display = "flex"; // Show badge modal
                }, 500);
            }
        });
    });

    // Close badge modal
    closeBadgeButton.addEventListener("click", () => {
        badgeModal.style.display = "none";
    });
});
