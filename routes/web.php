<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Livewire\Page\Home::class)->name('home');

Route::group(['prefix' => 'auth'], function () {
    Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'], '/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::match(['get', 'post'], '/reset', [AuthController::class, 'reset'])->name('reset');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'auth:web', 'prefix' => 'dashboard'], function () {
    Route::get('download/ketentuan.pdf', [DownloadController::class, 'ketentuan'])->name('download.ketentuan');
    Route::get('download/surat-kuasa.pdf', [DownloadController::class, 'suratKuasa'])->name('download.suratKuasa');
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/', \App\Http\Livewire\Admin\StatisticPage::class)->name('admin.dashboard');
        Route::get('ticket', \App\Http\Livewire\Admin\TicketPage::class)->name('admin.ticket');
        Route::get('users', \App\Http\Livewire\Admin\UserPage::class)->name('admin.users');
        Route::get('report', \App\Http\Livewire\Admin\ReportPage::class)->name('admin.report');
        Route::get('registration', \App\Http\Livewire\Cs\RegistrationPage::class)->name('admin.registration');
        Route::get('approval', \App\Http\Livewire\Admin\ApprovalPage::class)->name('admin.approval');
        Route::get('reconciliation', \App\Http\Livewire\Admin\Reconciliation::class)->name('admin.reconciliation');
        Route::get('validator', \App\Http\Livewire\Admin\ValidatorPage::class)->name('admin.validator');
    });

    Route::group(['middleware' => ['isUser']], function () {
        Route::get('/cs', \App\Http\Livewire\Cs\RegistrationPage::class)->name('cs.dashboard');
    });
});