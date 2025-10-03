<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EmployerApplicationController;
use App\Http\Middleware\EnsureEmployer;
use App\Http\Middleware\EnsureJobseeker;

Route::get('/', [RouteController::class, 'welcome'])->name('welcome');
Route::get('/register', [RouteController::class, 'showRegister'])->name('register');
Route::get('/login', [RouteController::class, 'showLogin'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/settings', [RouteController::class, 'showSettings'])->name('settings');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');


// Employer routes
Route::middleware(EnsureEmployer::class)->group(function () {
    Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::get('/jobs-list', [EmployerController::class, 'myJobs'])->name('jobs.list');
    Route::get('/create-job', [EmployerController::class, 'createJob'])->name('jobs.create');
    Route::post('/create-job', [EmployerController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [EmployerController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [EmployerController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [EmployerController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/applications-list', [EmployerController::class, 'applicantList'])->name('applications.list');
    Route::patch('/applications/{id}', [EmployerController::class, 'updateApplicant'])->name('applications.update');
    Route::get('applications/export-excel', [EmployerApplicationController::class, 'exportExcel'])->name('applications.export.excel');
});

// Jobseeker routes
Route::middleware(EnsureJobseeker::class)->group(function () {
    Route::get('/jobseeker/dashboard', [JobseekerController::class, 'dashboard'])->name('jobseeker.dashboard');
    Route::get('/jobs/find', [JobseekerController::class, 'find'])->name('jobs.find');
    Route::get('/view-job/{id}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/apply-job/{id}', [JobController::class, 'store'])->name('applications.store');
    Route::get('/my-applications', [JobseekerController::class, 'myApplications'])->name('my.applications');
});

