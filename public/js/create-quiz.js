// create-quiz.js (New Dynamic Quizizz-like Layout)

document.addEventListener("DOMContentLoaded", function () {
    // === Sidebar toggle logic ===
    const sidebar = document.querySelector("nav.sidebar");
    const toggleBtn = document.querySelector(".toggle");

    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    }

    // === Quiz Metadata Setup ===
    const meta = document.getElementById("quizMeta");
    const isEditMode = meta.dataset.editMode === "true";
    const quizId = meta.dataset.quizId || null;
    const loadedQuestions = JSON.parse(meta.dataset.questions || "[]");
    const classroomId = parseInt(document.getElementById("classroomMeta").dataset.classroomId);

        let questions = isEditMode && loadedQuestions.length > 0
        ? loadedQuestions.map(q => ({
            title: q.title || "",
            answers: q.answers || ["", "", "", ""],
            correctAnswers: q.correctAnswers || [false, false, false, false],
            slideNote: q.slideNote || "",
            points: q.points || 10,
            time: q.time || 30
        }))
        : [{
            title: "",
            answers: ["", "", "", ""],
            correctAnswers: [false, false, false, false],
            slideNote: "",
            points: 10,
            time: 30
        }];

    // === Render Questions Function ===
    function renderAllQuestions() {
        const container = document.getElementById("question-list");
        container.innerHTML = "";

        questions.forEach((q, index) => {
            const block = document.createElement("div");
            block.classList.add("question-block");

            block.innerHTML = `
   
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Question ${index + 1}</h3>
                <i class='bx bx-trash delete-question' data-index="${index}" 
                    style="position: absolute; top: 15px; right: 20px; font-size: 20px; color: red; cursor: pointer;">
                </i>
            </button>
            </div>
            <input type="text" class="question-title" value="${q.title}" placeholder="Enter your question...">

            <div class="question-meta-row">
                <select class="question-timer" data-q="${index}">
                    <option value="30" ${q.time === 30 ? "selected" : ""}>30s</option>
                    <option value="60" ${q.time === 60 ? "selected" : ""}>1 min</option>
                    <option value="90" ${q.time === 90 ? "selected" : ""}>1.5 min</option>
                    <option value="120" ${q.time === 120 ? "selected" : ""}>2 min</option>
                </select>

                <select class="question-points" data-q="${index}">
                    <option value="10" ${q.points === 10 ? "selected" : ""}>10 pts</option>
                    <option value="20" ${q.points === 20 ? "selected" : ""}>20 pts</option>
                    <option value="30" ${q.points === 30 ? "selected" : ""}>30 pts</option>
                    <option value="50" ${q.points === 50 ? "selected" : ""}>50 pts</option>
                </select>
            </div>

            <div class="answer-list">
                ${q.answers.map((ans, i) => `
                    <div class="answer-item">
                        <i class='bx ${q.correctAnswers[i] ? 'bx-checkbox-checked checked' : 'bx-checkbox'}' data-q="${index}" data-a="${i}"></i>
                        <input type="text" class="answer-input" data-q="${index}" data-a="${i}" value="${ans}" placeholder="Answer option">
                    </div>
                `).join('')}
            </div>

            <div class="slide-note-block">
                <label>Slide Note (Optional):</label>
                <textarea class="slide-note" data-q="${index}">${q.slideNote || ''}</textarea>
            </div>
        `;


            container.appendChild(block);
        });
    }

    // === Initial Render ===
    renderAllQuestions();

    // === Button Setup ===
    const addQuestionBtn = document.getElementById("add-question-btn");
    const saveBtn = document.getElementById("save-quiz");
    

    addQuestionBtn.addEventListener("click", () => {
        
        const points = 10;
        const time = 30;

    
        questions.push({
            title: "",
            answers: ["", "", "", ""],
            correctAnswers: [false, false, false, false],
            slideNote: "",
            points: points,
            time: time
        });
    
        renderAllQuestions();
    });
    
    

    saveBtn.addEventListener("click", () => {
        console.log("💾 Save clicked");
    
        const title = document.getElementById("quiz-title").value.trim();
        if (!title) return alert("Quiz title is required.");
    
        const total_time = questions.reduce((sum, q) => sum + (q.time || 0), 0);
        const total_points = questions.reduce((sum, q) => sum + (q.points || 0), 0);
    
        const payload = {
            title,
            timer_seconds: total_time,
            total_points,
            classroom_id: classroomId,
            questions: questions.map(q => ({
                text: q.title,
                slide_note: q.slideNote,
                points: q.points,
                time: q.time,
                answers: q.answers.map((a, i) => ({
                    text: a,
                    is_correct: q.correctAnswers[i]
                }))
            }))
        };
    
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = isEditMode && quizId ? `/quiz/${quizId}` : '/quiz';
        const method = isEditMode && quizId ? 'PUT' : 'POST';
    
        fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            alert(`🎉 Quiz successfully ${isEditMode ? 'updated' : 'created'}!`);
            window.location.href = "/teacher/quizzes";

        })
        .catch(err => {
            console.error("Error submitting quiz", err);
            alert("🚨 Submission failed.");
        });
    });
    



    // === Input Change Handlers ===
    document.addEventListener('input', function (e) {
        const target = e.target;

        if (target.classList.contains("question-title")) {
            const index = [...document.querySelectorAll(".question-title")].indexOf(target);
            questions[index].title = target.value;
        }

        if (target.classList.contains("answer-input")) {
            const qIndex = parseInt(target.dataset.q);
            const aIndex = parseInt(target.dataset.a);
            questions[qIndex].answers[aIndex] = target.value;
        }

        if (target.classList.contains("slide-note")) {
            const qIndex = parseInt(target.dataset.q);
            questions[qIndex].slideNote = target.value;
        }

        if (target.classList.contains("question-timer")) {
            const qIndex = parseInt(target.dataset.q);
            questions[qIndex].time = parseInt(target.value);
        }
        
        if (target.classList.contains("question-points")) {
            const qIndex = parseInt(target.dataset.q);
            questions[qIndex].points = parseInt(target.value);
        }
        
    });

 
    document.addEventListener("click", function (e) {
        if (e.target.closest(".delete-question")) {
            const index = parseInt(e.target.closest(".delete-question").dataset.index);
            questions.splice(index, 1);
            renderAllQuestions();
        }
    
        if (e.target.classList.contains("bx-checkbox") || e.target.classList.contains("bx-checkbox-checked")) {
            const qIndex = parseInt(e.target.dataset.q);
            const aIndex = parseInt(e.target.dataset.a);
            questions[qIndex].correctAnswers[aIndex] = !questions[qIndex].correctAnswers[aIndex];
            renderAllQuestions();
        }
    });
    
});
