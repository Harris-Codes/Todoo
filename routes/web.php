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

Route::get('/student/dashboard', function () {
    return view('homepage'); // Loads homepage.blade.php
})->name('student.dashboard')->middleware('auth');


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

// Create Quiz page
Route::get('/create-quiz', function () {
    return view('create-quiz');
});



//=================================Controllers====================================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TeacherClassroomController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AssignmentController;

//Login and Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Register
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

//Classroom
Route::middleware('auth')->group(function () {
    Route::get('/teacher', [ClassroomController::class, 'index'])->name('teacher.dashboard');
    Route::post('/classroom/create', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::delete('/classroom/{id}', [ClassroomController::class, 'destroy'])->name('classroom.destroy');
    
});

Route::get('/classroom/{id}', [ClassroomController::class, 'show'])->name('classroom.show');

Route::get('/teacher/classroom/{id}', [TeacherClassroomController::class, 'show'])->name('teacher.classroom');
//Post
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

//Assignment
Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

//Assignment-delete
Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

//Assignment-edit
Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
