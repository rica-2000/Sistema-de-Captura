<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Livewire\Coordinator\Subjects as CoordinatorSubjects;
use App\Livewire\Coordinator\Users as CoordinatorUsers;
use App\Livewire\Coordinator\Assignments as CoordinatorAssignments;
use App\Livewire\Coordinator\Enrollments as CoordinatorEnrollments;
use App\Livewire\Teacher\Grades as TeacherGrades;
use App\Livewire\Student\MyGrades as StudentMyGrades;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Coordinador
Route::middleware(['auth','role:coordinador'])->group(function(){
    Route::get('/coordinador/materias', CoordinatorSubjects::class)->name('coordinator.subjects');
    Route::get('/coordinador/usuarios', CoordinatorUsers::class)->name('coordinator.users');
    Route::get('/coordinador/asignaciones', CoordinatorAssignments::class)->name('coordinator.assignments');
    Route::get('/coordinador/inscripciones', CoordinatorEnrollments::class)->name('coordinator.enrollments');
});

// Maestro
Route::middleware(['auth','role:maestro'])->group(function(){
    Route::get('/maestro/calificaciones', TeacherGrades::class)->name('teacher.grades');
});

// Alumno
Route::middleware(['auth','role:alumno'])->group(function(){
    Route::get('/alumno/mis-calificaciones', StudentMyGrades::class)->name('student.my-grades');
});

require __DIR__.'/auth.php';
