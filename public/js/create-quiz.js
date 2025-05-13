//====================== CHECK MARK FOR RIGHT ANSWER ==========================
function toggleCheck(icon) {
    icon.classList.toggle('checked'); // Toggle the check state
    icon.classList.toggle('bx-checkbox'); // Default unchecked state
    icon.classList.toggle('bx-checkbox-checked'); // Checked state
}

// =========================== MAIN HEADER BUTTONS ============================
document.addEventListener("DOMContentLoaded", function () {
    // Toggle dropdowns on button click
    document.querySelectorAll(".dropdown-btn").forEach(button => {
        button.addEventListener("click", function (event) {
            const dropdown = this.nextElementSibling;
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

            // Close other dropdowns
            document.querySelectorAll(".dropdown-content").forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.style.display = "none";
                }
            });

            event.stopPropagation(); // Prevents triggering the document click event
        });
    });

    // Prevent dropdown from closing when clicking inside it
    document.querySelectorAll(".dropdown-content").forEach(dropdown => {
        dropdown.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents the document click from closing it
        });
    });

    // Close dropdown if clicked outside
    document.addEventListener("click", function (event) {
        document.querySelectorAll(".dropdown-content").forEach(dropdown => {
            if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
    });

    // Save button action
    document.querySelector(".save-btn").addEventListener("click", function () {
        alert("Quiz saved successfully!");
    });

    // Add question button action
    document.querySelector(".add-question-btn").addEventListener("click", function () {
        alert("New question added!");
    });
});

//========================================== NEXT QUESTION ==============================
document.addEventListener("DOMContentLoaded", function () {
    let questionNumber = 1; // Start from Question 1
    const questionTitle = document.getElementById("question-title");
    const addQuestionBtn = document.querySelector(".add-question-btn");
    const prevQuestionBtn = document.querySelector(".prev-question-btn");
    const nextQuestionBtn = document.querySelector(".next-question-btn");

    let questions = [
        {
            title: "Input your question here..",
            answers: ["Input your answer here..", "Input your answer here..", "Input your answer here..", "Input your answer here.."]
        }
    ];

    function renderQuestion() {
        const currentQuestion = questions[questionNumber - 1]; // Adjust for 0-based index
        questionTitle.textContent = `QUESTION ${questionNumber}`;

        // Update question text
        document.querySelector(".question h2").textContent = currentQuestion.title;

        // Update answer options
        const answerElements = document.querySelectorAll(".answers h3");
        answerElements.forEach((element, index) => {
            element.textContent = currentQuestion.answers[index];
        });

        // Toggle button states
        prevQuestionBtn.disabled = questionNumber === 1;
        nextQuestionBtn.disabled = questionNumber === questions.length;
    }

    // Add a new question
    addQuestionBtn.addEventListener("click", function () {
        questionNumber++;
        questions.push({
            title: "Input your question here..",
            answers: ["Input your answer here..", "Input your answer here..", "Input your answer here..", "Input your answer here.."]
        });

        renderQuestion();
    });

    // Previous Question
    prevQuestionBtn.addEventListener("click", function () {
        if (questionNumber > 1) {
            questionNumber--;
            renderQuestion();
        }
    });

    // Next Question
    nextQuestionBtn.addEventListener("click", function () {
        if (questionNumber < questions.length) {
            questionNumber++;
            renderQuestion();
        }
    });

    renderQuestion();
});


//=====================INPUTS===================================

document.addEventListener("DOMContentLoaded", function () {
    let questionNumber = 1; // Start from Question 1
    const questionTitle = document.getElementById("question-title");
    const addQuestionBtn = document.querySelector(".add-question-btn");
    const prevQuestionBtn = document.querySelector(".prev-question-btn");
    const nextQuestionBtn = document.querySelector(".next-question-btn");
    const quizTitleInput = document.getElementById("quiz-title");
    const questionInput = document.getElementById("question-input");
    const answerInputs = document.querySelectorAll(".answer-input");

    let questions = [
        {
            title: "",
            answers: ["", "", "", ""]
        }
    ];

    function renderQuestion() {
        const currentQuestion = questions[questionNumber - 1]; // Adjust for 0-based index
        questionTitle.textContent = `QUESTION ${questionNumber}`;

        // Load stored data into inputs
        questionInput.value = currentQuestion.title;
        answerInputs.forEach((input, index) => {
            input.value = currentQuestion.answers[index];
        });

        // Toggle button states
        prevQuestionBtn.disabled = questionNumber === 1;
        nextQuestionBtn.disabled = questionNumber === questions.length;
    }

    function saveCurrentQuestion() {
        // Save input values before changing questions
        questions[questionNumber - 1].title = questionInput.value;
        answerInputs.forEach((input, index) => {
            questions[questionNumber - 1].answers[index] = input.value;
        });
    }

    // Add a new question
    addQuestionBtn.addEventListener("click", function () {
        saveCurrentQuestion();
        questionNumber++;
        questions.push({ title: "", answers: ["", "", "", ""] });
        renderQuestion();
    });

    // Previous Question
    prevQuestionBtn.addEventListener("click", function () {
        if (questionNumber > 1) {
            saveCurrentQuestion();
            questionNumber--;
            renderQuestion();
        }
    });

    // Next Question
    nextQuestionBtn.addEventListener("click", function () {
        if (questionNumber < questions.length) {
            saveCurrentQuestion();
            questionNumber++;
            renderQuestion();
        }
    });

    // Save Quiz Name
    quizTitleInput.addEventListener("input", function () {
        localStorage.setItem("quizTitle", quizTitleInput.value);
    });

    renderQuestion();
});
