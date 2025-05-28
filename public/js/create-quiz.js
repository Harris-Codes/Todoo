// ===== Global Variables =====
let questionNumber = 1;
let questions = [
    {
        title: "",
        answers: ["", "", "", ""],
        slideNote: ""
    }
];

// ====== Global Helpers ======

window.toggleCheck = function(icon) {
    icon.classList.toggle('checked');
    icon.classList.toggle('bx-checkbox');
    icon.classList.toggle('bx-checkbox-checked');
};
function saveCurrentQuestion() {
    const questionInput = document.getElementById("question-input");
    const answerInputs = document.querySelectorAll(".answer-input");
    const slideNoteInput = document.getElementById("slide-note");

    questions[questionNumber - 1].title = questionInput.value;
    questions[questionNumber - 1].answers = Array.from(answerInputs).map(input => input.value);
    if (slideNoteInput) {
        questions[questionNumber - 1].slideNote = slideNoteInput.value;
    }
}

function renderQuestion() {
    const current = questions[questionNumber - 1];

    const questionTitle = document.getElementById("question-title");
    const questionInput = document.getElementById("question-input");
    const answerInputs = document.querySelectorAll(".answer-input");
    const slideNoteInput = document.getElementById("slideNote"); 


    if (!questionTitle || !questionInput || !answerInputs.length) return;

    questionTitle.textContent = `QUESTION ${questionNumber}`;
    questionInput.value = current.title;
    answerInputs.forEach((input, index) => {
        input.value = current.answers[index] || "";
    });

    if (slideNoteInput) {
        slideNoteInput.value = current.slideNote || "";
    }

    function toggleCheck(icon) {
        icon.classList.toggle('checked');
        icon.classList.toggle('bx-checkbox');
        icon.classList.toggle('bx-checkbox-checked');
    }
    

    // Toggle button states
    document.querySelector(".prev-question-btn").disabled = questionNumber === 1;
    document.querySelector(".next-question-btn").disabled = questionNumber === questions.length;
}

// ====== DOM Ready ======
document.addEventListener("DOMContentLoaded", function () {
    const addQuestionBtn = document.querySelector(".add-question-btn");
    const prevBtn = document.querySelector(".prev-question-btn");
    const nextBtn = document.querySelector(".next-question-btn");
    const publishBtn = document.querySelector(".publish-btn");
    const quizTitleInput = document.getElementById("quiz-title");

    // Navigation buttons
    addQuestionBtn.addEventListener("click", () => {
        saveCurrentQuestion();
        questions.push({ title: "", answers: ["", "", "", ""], slideNote: "" });
        questionNumber++;
        renderQuestion();
    });

    prevBtn.addEventListener("click", () => {
        if (questionNumber > 1) {
            saveCurrentQuestion();
            questionNumber--;
            renderQuestion();
        }
    });

    nextBtn.addEventListener("click", () => {
        if (questionNumber < questions.length) {
            saveCurrentQuestion();
            questionNumber++;
            renderQuestion();
        }
    });

    // Publish button
    publishBtn.addEventListener("click", () => {
        saveCurrentQuestion();

        const title = quizTitleInput.value.trim();
        const timer = parseInt(document.getElementById("timer-select").value);
        const points = parseInt(document.getElementById("points-select").value);
        const classroomId = parseInt(document.getElementById("classroomMeta").dataset.classroomId);


        if (!title) return alert("Quiz title is required.");

        const payload = {
            title: title,
            timer_seconds: timer,
            total_points: points,
            classroom_id: classroomId,
            questions: questions.map(q => ({
                text: q.title,
                slide_note: q.slideNote || null,
                points: q.points || 0,
                time: q.time || 0,
                answers: q.answers.map((a, i) => ({
                    text: a,
                    is_correct: document.querySelectorAll(".answers i")[i]?.classList.contains("checked") || false
                }))
            }))
            
        };

        if (!classroomId || isNaN(classroomId)) {
            alert("❌ Classroom ID is missing or invalid.");
            return;
        }


       // Get the CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Use this inside your fetch request:
        // ✅ Corrected fetch request using the already defined variables
        fetch('/quiz', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload) // ✅ This is the correctly structured data
        })
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok.");
            return response.json();
        })
        .then(data => {
            console.log('✅ Quiz Created', data);
            alert("🎉 Quiz successfully created!");
        })
        .catch(error => {
            console.error("🚨 Submit error:", error.message);
            alert("🚨 Server Error: Check console for details.");
        });


        
        
    });

    renderQuestion(); // initial call
});
