<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationHistoryController;
use App\Http\Controllers\Admin\JobHistoryController;
use App\Http\Controllers\AjaxLoadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeachingHistoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');
Route::get('/cek-report', function () {
    return view('pages.admin.report.show');
})->name('cek.report');

Route::get('/pdf', function () {
    return view('pages.admin.report.pdf');
})->name('cek.pdf');

Route::get('/pdf-2', function () {
    $teacher = App\Models\Teacher::first();
    return view('pages.admin.report.pdf-2', compact('teacher'));
})->name('cek.pdf-2');

Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/pengaturan-akun', [AuthController::class, 'edit'])->name('pengaturan-akun.edit');
Route::put('/pengaturan-akun', [AuthController::class, 'update'])->name('pengaturan-akun.update');
Route::get('/search-guru', [AjaxLoadController::class, 'getGuru'])->name('search.guru');
Route::get('/search-siswa', [AjaxLoadController::class, 'getSiswa'])->name('search.siswa');
Route::get('/search-jadwal-pembelajaran', [AjaxLoadController::class, 'getJadwalPembelajaran'])->name('search.jadwal.pembelajaran');

Route::middleware(['auth', 'role:1'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', UserController::class);
    Route::resource('/teacher', TeacherController::class);
    Route::get('/teacher/{teacher}/document/upload', [TeacherController::class, 'formUpload'])->name('teacher.document.upload');
    Route::post('/teacher/{teacher}/document/upload', [TeacherController::class, 'upload'])->name('teacher.document.store');
    Route::delete('/teacher/{teacher}/document/{file}', [TeacherController::class, 'destroyDocument'])->name('teacher.document.destroy');
    Route::put('/teacher/{teacher}/status', [TeacherController::class, 'status'])->name('teacher.status');
    Route::get('/education-history', [EducationHistoryController::class, 'index'])->name('education-history.index');
    Route::get('/education-history/{teacher}', [EducationHistoryController::class, 'show'])->name('education-history.show');
    Route::post('/education-history', [EducationHistoryController::class, 'store'])->name('education-history.store');
    Route::put('/education-history/{education_history}', [EducationHistoryController::class, 'update'])->name('education-history.update');
    Route::delete('/education-history/{education_history}', [EducationHistoryController::class, 'destroy'])->name('education-history.destroy');
    Route::get('/job-history', [JobHistoryController::class, 'index'])->name('job-history.index');
    Route::get('/job-history/{teacher}', [JobHistoryController::class, 'show'])->name('job-history.show');
    Route::post('/job-history', [JobHistoryController::class, 'store'])->name('job-history.store');
    Route::put('/job-history/{job_history}', [JobHistoryController::class, 'update'])->name('job-history.update');
    Route::delete('/job-history/{job_history}', [JobHistoryController::class, 'destroy'])->name('job-history.destroy');
    Route::get('/teaching-history', [TeachingHistoryController::class, 'index'])->name('teaching-history.index');
    Route::get('/teaching-history/{teacher}', [TeachingHistoryController::class, 'show'])->name('teaching-history.show');
    Route::post('/teaching-history', [TeachingHistoryController::class, 'store'])->name('teaching-history.store');
    Route::put('/teaching-history/{teaching_history}', [TeachingHistoryController::class, 'update'])->name('teaching-history.update');
    Route::delete('/teaching-history/{teaching_history}', [TeachingHistoryController::class, 'destroy'])->name('teaching-history.destroy');

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/{teacher}', [ReportController::class, 'show'])->name('report.show');
    Route::get('/report/{teacher}/download', [ReportController::class, 'download'])->name('report.download');
});
