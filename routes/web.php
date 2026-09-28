<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Student\BookController as StudentBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Student\LoanController as StudentLoanController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Student\PasswordController as StudentPasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ShelfController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\HistoryController;

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

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('student', StudentController::class);
    Route::get('/student/{student}/change-password', [StudentController::class, 'changePassword'])->name('student.change-password');
    Route::put('/student/{student}/change-password', [StudentController::class, 'updatePassword'])->name('student.update-password');
    Route::resource('book', BookController::class);
    Route::resource('shelf', ShelfController::class);
    Route::resource('report', ReportController::class);
    Route::resource('loan', LoanController::class);
    Route::get('/loan/{loan}/return', [LoanController::class, 'createReturn'])->name('loan.return.create');
    Route::put('/loan/{loan}/return', [LoanController::class, 'return'])->name('loan.return');
    Route::resource('category', CategoryController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('password', PasswordController::class);
});

Route::middleware(['auth', 'role:student'])->name('student.')->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::resource('profile', StudentProfileController::class);
    Route::resource('password', StudentPasswordController::class);
    Route::resource('book', StudentBookController::class);
    Route::resource('history', HistoryController::class);
    Route::get('/loan', [StudentLoanController::class, 'index'])->name('loan.index');
    Route::get('/loan/{loan}', [StudentLoanController::class, 'show'])->name('loan.show');
    Route::get('/loan/{book}/create', [StudentLoanController::class, 'create'])->name('loan.create');
    Route::put('/loan/{loan}/cancel', [StudentLoanController::class, 'cancel'])->name('loan.cancel');
    Route::post('/loan', [StudentLoanController::class, 'store'])->name('loan.store');

});
