<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
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


Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('main');
    Route::get('/generateSignature', [PaymentController::class, 'generateSignature'])->name('generate_signature');
    Route::post('/submit-form', [PaymentController::class, 'preparePaymentData'])->name('prepare_payment');
    Route::post('/registration/store', [RegistrationController::class, 'store'])->name('store_registration');
    Route::put('/registration/update-session-id', [PaymentController::class, 'updateSessionId'])->name('update_session_id');
    Route::get('/registration/validate-payment/{id}', [PaymentController::class, 'validatePayment'])->name('validate_payment');
    Route::get('/registration/details/{id}', [RegistrationController::class, 'show'])->name('registration_details');

});

// Route::get('/admin', function () {return view('dashboard');})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', [AdminCOntroller::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

    Route::get('/admin/registration/list/{cat}', [AdminCOntroller::class, 'showRegistrations'])->name('admin_show_registrations');
    Route::get('/admin/registration/validate-form/', [AdminController::class, 'validatePaymentForm'])->name('validate_payment_form');
    Route::get('/admin/get-payment-details/{paymentId}', [AdminController::class, 'getPaymentDetails'])->name('validate_payment_get_details');
    Route::get('/admin/registration/remove/{requestId}', [AdminController::class, 'deletePayment'])->name('delete_payment');
    Route::get('/admin/registration/mail-resend-form/', [AdminController::class, 'mailResendForm'])->name('mail_resend_form');
    Route::post('/admin/registration/mail-resend', [AdminController::class, 'resendMail'])->name('resend_email');

});

require __DIR__.'/auth.php';

Route::get('/crypt/{id}', function ($id) {
    return Crypt::encrypt($id);
});
Route::get('/authcheck', function () {
    if (Auth::check()) {
        dd('Authenticated');
    } else {
        dd('Not Authenticated');
    }
});