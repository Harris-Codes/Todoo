let timer;
let timeLeft = 60;
let currentQuestionIndex = 0;
let correctAnswers = 0;

// Fetch quiz data from HTML
const quizElement = document.getElementById('quizData');
const quiz = JSON.parse(quizElement.dataset.quiz);
const questions = quiz.questions;
const soundCorrect = document.getElementById('sound-correct');
const soundWrong = document.getElementById('sound-wrong');


// Quiz Title
document.querySelector('.creation-header h1').textContent = quiz.title;

function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${mins}:${secs.toString().padStart(2, '0')}`;
}

function startTimer(duration) {
    clearInterval(timer);
    timeLeft = duration;
    document.getElementById('countdown').textContent = formatTime(timeLeft);

    const timerBar = document.getElementById("timerBar");
    timerBar.style.width = "100%";

    const totalTime = duration;

    timer = setInterval(() => {
        timeLeft--;
        document.getElementById('countdown').textContent = formatTime(timeLeft);

        const percentage = (timeLeft / totalTime) * 100;
        timerBar.style.width = percentage + "%";

        if (timeLeft <= 0) {
            clearInterval(timer);
            autoSelectNone();
            nextQuestion();
        }
    }, 1000);
}


function renderQuestionSkeleton() {
    document.querySelector(".creation-main").innerHTML = `
        <h1 id="question-title">QUESTION 1</h1>

        <div class="timer-section">
            <div class="timer-info">
                Time left: <strong id="countdown">--</strong> seconds
            </div>
            <div class="timer-bar-container">
                <div class="timer-bar" id="timerBar"></div>
            </div>
        </div>

        <div class="question-meta">
            <i class='bx bxs-medal'></i>
            <span id="points">Points: <strong id="questionPoints">--</strong></span>
        </div>

        <div class="question-container">
            <p class="question">Loading question...</p>
        </div>

        <div class="answer-container"></div>
    `;
}


function loadQuestion(index) {
    const q = questions[index];
    document.querySelector('.question').textContent = q.text;
    document.getElementById('question-title').textContent = `QUESTION ${index + 1}`;
    document.getElementById('questionPoints').textContent = q.points;

    const answerContainer = document.querySelector('.answer-container');
    answerContainer.innerHTML = "";

    q.options.forEach((opt, i) => {
        const btn = document.createElement("button");
        btn.classList.add("answer-btn");
        btn.dataset.answer = i;
        btn.textContent = opt;
        btn.addEventListener("click", function () {
            handleAnswerClick(this, i, q.correct, q.points);
        });
        answerContainer.appendChild(btn);
    });

    startTimer(q.time);
}

function handleAnswerClick(button, selected, correct, points) {
    clearInterval(timer);

    const allButtons = document.querySelectorAll(".answer-btn");
    allButtons.forEach(btn => btn.classList.add("disabled"));

    if (selected === correct) {
        button.classList.add("correct-answer");
        correctAnswers += points;

        soundCorrect.pause();
        soundCorrect.currentTime = 0;
        soundCorrect.play();
    } else {
        button.classList.add("wrong-answer");
        allButtons[correct].classList.add("correct-answer");

        soundWrong.pause();
        soundWrong.currentTime = 0;
        soundWrong.play();
    }

    setTimeout(() => {
        nextQuestion();
    }, 1500);
}


function autoSelectNone() {
    const q = questions[currentQuestionIndex];
    const buttons = document.querySelectorAll(".answer-btn");
    buttons.forEach((btn, i) => {
        btn.classList.add("disabled");
        if (i === q.correct) {
            btn.classList.add("correct-answer");
        }
    });
}

async function nextQuestion() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        loadQuestion(currentQuestionIndex);
    } else {
        submitQuiz(quizElement.dataset.quizId, correctAnswers);
        document.getElementById('quizCompleteModal').style.display = 'flex';

        setTimeout(() => {
            const classroomId = document.getElementById("classroomMeta").dataset.classroomId;
            window.location.href = `/student/classroom/${classroomId}`;
        }, 3000);
    }
}



function submitQuiz(quizId, score) {
    // 🚫 Disable warning after submission
    window.removeEventListener('beforeunload', beforeUnloadHandler);

    fetch(`/quiz/${quizId}/submit`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({ score: score })
    })
    .then(res => {
        if (!res.ok) throw new Error("Submission failed");
        return res.json();
    })
    .catch(err => {
        console.error(err);
        alert("There was a problem submitting your quiz. Please try again.");
    });
}

function beforeUnloadHandler(e) {
    const currentQuizId = quizElement.dataset.quizId;
    const currentScore = correctAnswers;

    navigator.sendBeacon(`/quiz/${currentQuizId}/submit`, new Blob([
        JSON.stringify({
            score: currentScore,
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        })
    ], { type: 'application/json' }));

    e.preventDefault();
    e.returnValue = '';
}

window.onload = () => {
    renderQuestionSkeleton();
    loadQuestion(currentQuestionIndex);
       // Enable unload warning when quiz starts
       window.addEventListener('beforeunload', beforeUnloadHandler);
};

// Go back button
document.getElementById("goBackButton").addEventListener("click", () => {
    const classroomId = document.getElementById("classroomMeta")?.dataset.classroomId || "/student/homepage";
    window.location.href = `/student/classroom/${classroomId}`;
});
