<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//=================================Routes====================================
//Login
Route::get('/login', function () {
    return view('login'); // References the login.blade.php file
});

//Register Page
Route::get('/register', function () {
    return view('register'); // This references resources/views/register.blade.php
});

// =================Role-based dashboard redirection=========================
Route::get('/teacher/dashboard', function () {
    return view('teacher'); // Loads teacher.blade.php
})->name('teacher.dashboard')->middleware('auth');


// Forgot Password Page
Route::get('/forgot-password', function () {
    return view('forgot-password');
});

// Homepage
Route::get('/homepage', function () {
    return view('homepage');
});

// Classroom 
Route::get('/classroom', function () {
    return view('classroom');
});

// Quiz 
Route::get('/quiz', function () {
    return view('quiz');
});

// dashboard 
Route::get('/dashboard', function () {
    return view('dashboard');
});

// teacher homepage 
Route::get('/teacher', function () {
    return view('teacher');
});

// teacher classroom BM 
Route::get('/teacher-classroom', function () {
    return view('teacher-classroom');
});




//=================================Controllers====================================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherClassroomController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubmissionController;
//------------------------------------Login Page------------------------------
//Login and Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Register
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

//-----------------------------------Classroom----------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/teacher', [ClassroomController::class, 'index'])->name('teacher.dashboard');
    Route::post('/classroom/create', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::delete('/classroom/{id}', [ClassroomController::class, 'destroy'])->name('classroom.destroy');
    
});

Route::get('/classroom/{id}', [ClassroomController::class, 'show'])->name('classroom.show');

Route::get('/teacher/classroom/{id}', [TeacherClassroomController::class, 'show'])->name('teacher.classroom');

// ============================ POST ============================ //
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


// ============================ ASSIGNMENT ============================ //
Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

//Assignment-delete
Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

//Assignment-edit
Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');

//Adding Student into the classroom (Student Tab)
Route::post('/classrooms/{classroom}/students', [TeacherClassroomController::class, 'addStudent'])->name('classroom.addStudent');
//Delete Student from the classroom (Student Tab)
Route::delete('/classrooms/{classroom}/students/{student}', [TeacherClassroomController::class, 'removeStudent'])->name('classroom.removeStudent');
//Submissions
Route::get('/assignments/{id}/submissions', [SubmissionController::class, 'getByAssignment']);
//Grade
Route::post('/submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
//Reset Grade
Route::post('/submissions/{id}/grade/reset', [SubmissionController::class, 'resetGrade'])->name('submissions.grade.reset');

// ============================ FILE ROUTES ============================ //
Route::prefix('classroom/{classroom}')->middleware('auth')->group(function () {
    Route::post('/folders', [FolderController::class, 'store'])->name('folders.store');
    Route::get('/folders/list', [FolderController::class, 'list'])->name('folders.list');
    Route::get('/folders/{folder}/files', [FolderController::class, 'getFiles'])->name('folders.files');

    Route::post('/files', [FileController::class, 'uploadToRoot'])->name('files.upload.root');
    Route::get('/files/root', [FileController::class, 'listRootFiles'])->name('files.root');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.delete');
    Route::post('/folders/{folder}/files', [FileController::class, 'uploadToFolder'])->name('files.upload.folder');

});
Route::post('/classroom/{classroom}/folders/{folder}/files', [FileController::class, 'uploadToFolder'])
    ->middleware('auth')
    ->name('files.upload.folder');



// ============================ QUIZ ============================ //
//New quiz over view page
Route::get('/teacher/quizzes', [QuizController::class, 'overview'])->name('quiz.overview');
Route::get('/classroom/{classroom}/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
Route::get('/classroom/{classroom_id}/create-quiz', [QuizController::class, 'showCreateQuiz'])->name('quiz.create');
Route::post('/quiz', [QuizController::class, 'store'])->name('quizzes.store');
Route::get('/classroom/{classroom_id}/quiz/{quiz_id}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
//update or replace existing quizz
Route::put('/quiz/{quiz}', [QuizController::class, 'update'])->name('quiz.update');
//manage
Route::get('/teacher/quiz/{quiz}/manage', [QuizController::class, 'manage'])->name('quiz.manage');
//Result
Route::get('/teacher/quiz/{quiz_id}/results', [QuizController::class, 'viewResults'])->name('teacher.quiz.results');

//publish
Route::post('/teacher/quiz/{quiz}/publish', [QuizController::class, 'publish'])->name('quiz.publish');





//==================== STUDENT ===========================
//STUDENT HOMEPAGE
Route::get('/student/homepage', [ClassroomController::class, 'studentHomepage'])->name('student.homepage')->middleware('auth');
//JOIN CLASSROOM
Route::post('/student/join-classroom', [ClassroomController::class, 'join'])->name('classroom.join');
//LEAVE CLASSROOM
Route::delete('/student/classroom/{classroom}', [ClassroomController::class, 'leave'])->name('classroom.leave')->middleware('auth');
//SHOW CLASSROOM
Route::get('/student/classroom/{id}', [ClassroomController::class, 'studentClassroom'])->name('student.classroom')->middleware('auth');
//REPLY COMMENT
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
//SUBMIT ASSIGNMENT
Route::post('/submit-assignment', [SubmissionController::class, 'store'])->name('assignment.submit');
//Download Files
Route::get('/download/{file}', [FileController::class, 'download'])->name('file.download');
//Attempt Quiz
Route::post('/quiz/{quiz}/submit', [QuizController::class, 'submitAttempt'])->name('quiz.submit');

