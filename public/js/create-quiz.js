// ==== Load Meta from Blade (via data attributes) ====
const meta = document.getElementById("quizMeta");
const isEditMode = meta.dataset.editMode === "true";
const quizId = meta.dataset.quizId || null;
const loadedQuestions = JSON.parse(meta.dataset.questions || "[]");


// ===== Global Variables =====
let questionNumber = 1;
let questions = isEditMode && loadedQuestions.length > 0
    ? loadedQuestions
    : [{
        title: "",
        answers: ["", "", "", ""],
        correctAnswers: [false, false, false, false],
        slideNote: "",
        points: 10,
        time: 30
    }];




// ====== Global Helpers ======

window.toggleCheck = function(icon) {
    icon.classList.toggle('checked');
    icon.classList.toggle('bx-checkbox');
    icon.classList.toggle('bx-checkbox-checked');
};

function saveAllQuestions() {
    console.log(`💾 Question ${questionNumber} saved.`);
    questions.forEach((q, index) => {
        if (index === questionNumber - 1) {
            const questionInput = document.getElementById("question-input");
            const answerInputs = document.querySelectorAll(".answer-input");
            const slideNoteInput = document.getElementById("slide-note");
            const correctIcons = document.querySelectorAll(".answers i");

            q.title = questionInput.value;
            q.answers = Array.from(answerInputs).map(input => input.value);
            q.correctAnswers = Array.from(correctIcons).map(icon =>
                icon.classList.contains("checked")
            );
            q.slideNote = slideNoteInput.value;

            
            q.points = parseInt(document.getElementById("points-select").value);
            q.time = parseInt(document.getElementById("timer-select").value);
        }
    });
}




function renderQuestion() {
    const current = questions[questionNumber - 1];

    const questionTitle = document.getElementById("question-title");
    const questionInput = document.getElementById("question-input");
    const answerInputs = document.querySelectorAll(".answer-input");
    const slideNoteInput = document.getElementById("slide-note");
    const correctIcons = document.querySelectorAll(".answers i");

    if (!questionTitle || !questionInput || !answerInputs.length) return;

    questionTitle.textContent = `QUESTION ${questionNumber}`;
    questionInput.value = current.title;
    answerInputs.forEach((input, index) => {
        input.value = current.answers[index] || "";
    });

    correctIcons.forEach((icon, index) => {
        icon.classList.remove("checked", "bx-checkbox-checked");
        icon.classList.add("bx-checkbox");

        if (current.correctAnswers && current.correctAnswers[index]) {
            icon.classList.remove("bx-checkbox");
            icon.classList.add("checked", "bx-checkbox-checked");
        }
    });

    if (slideNoteInput) {
        slideNoteInput.value = current.slideNote || "";
    }

    document.getElementById("points-select").value = current.points || 10;
    document.getElementById("timer-select").value = current.time || 30;

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
    const saveBtn = document.querySelector(".save-btn");


    // Navigation buttons
    addQuestionBtn.addEventListener("click", () => {
        saveAllQuestions();
    
        const points = parseInt(document.getElementById("points-select").value);
        const time = parseInt(document.getElementById("timer-select").value);
    
        questions.push({
            title: "",
            answers: ["", "", "", ""],
            correctAnswers: [false, false, false, false],
            slideNote: "",
            points: points,   // ✅ save current value
            time: time        // ✅ save current value
        });
    
        questionNumber++;
        renderQuestion();
    });
    

    prevBtn.addEventListener("click", () => {
        if (questionNumber > 1) {
            saveAllQuestions();
            questionNumber--;
            renderQuestion();
        }
    });

    nextBtn.addEventListener("click", () => {
        if (questionNumber < questions.length) {
            saveAllQuestions();
            questionNumber++;
            renderQuestion();
        }
    });

    saveBtn.addEventListener("click", () => {
        console.log("💾 Save button clicked");
        saveAllQuestions(); // Optional: or saveAllQuestions() if you prefer
    });
    

    // Publish button
    publishBtn.addEventListener("click", () => {
        saveAllQuestions();

        const title = quizTitleInput.value.trim();
        const classroomId = parseInt(document.getElementById("classroomMeta").dataset.classroomId);
        const total_time = questions.reduce((sum, q) => sum + (q.time || 0), 0);
        const total_points = questions.reduce((sum, q) => sum + (q.points || 0), 0);



        if (!title) return alert("Quiz title is required.");

        const payload = {
            title: title,
            timer_seconds: total_time,
            total_points: total_points, //  this is the sum of all question points
            classroom_id: classroomId,
            questions: questions.map(q => ({
                text: q.title,
                slide_note: q.slideNote || null,
                points: q.points || 0,
                time: q.time || 0,
                answers: q.answers.map((a, i) => ({
                    text: a,
                    is_correct: q.correctAnswers[i]
                }))
            }))
        };
        

        if (!classroomId || isNaN(classroomId)) {
            alert("❌ Classroom ID is missing or invalid.");
            return;
        }


       // Get the CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log("🚀 Final payload", payload);
        const url = isEditMode && quizId ? `/quiz/${quizId}` : '/quiz';
        const method = isEditMode && quizId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok.");
            return response.json();
        })
        .then(data => {
            console.log('✅ Quiz Submitted', data);
            alert(`🎉 Quiz successfully ${isEditMode ? 'updated' : 'created'}!\nRedirecting to classroom...`);
            setTimeout(() => {
                window.location.href = `/teacher/classroom/${classroomId}`;
            }, 1000);
        })
        .catch(error => {
            console.error("🚨 Submit error:", error.message);
            alert("🚨 Server Error: Check console for details.");
        });



        
        
    });

    renderQuestion(); // initial call
});
