<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
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
    Route::get('test', fn () => phpinfo());

});
