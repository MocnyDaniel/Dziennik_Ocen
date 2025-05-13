<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\LogController;

// Główna strona (publiczna)
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard dostępny po zalogowaniu – przekierowanie według roli
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.users.index'),
        'teacher' => redirect()->route('teacher.grades.index'),
        'user' => redirect()->route('student.grades.index'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


// Trasy dla zalogowanych użytkowników – profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel admina i zarządzanie użytkownikami
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

// Panel nauczyciela
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('grades/logs', [GradeController::class, 'logs'])->name('grades.logs');
    Route::resource('grades', GradeController::class);
});

// Panel ucznia
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/student/grades/statistics', [StudentGradeController::class, 'statistics'])->name('student.grades.statistics');
    Route::get('/student/grades', [StudentGradeController::class, 'index'])->name('student.grades.index');
    Route::get('/student/grades/{grade}', [StudentGradeController::class, 'show'])->name('student.grades.show');
});

// Auth routes (Breeze / Fortify / Jetstream)
require __DIR__.'/auth.php';