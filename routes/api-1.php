<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| User Api
|--------------------------------------------------------------------------
*/




// payment gateway api

Route::post('/card-payment', [UserController::class,'cardpayment'])->name('card.payment');



// payment gateway api


Route::get('sendNotificationrToUser', [UserController::class,'sendNotificationrToUser'])->name('sendNotificationrToUser');



Route::post('/mac-login', [UserController::class,'maclogin'])->name('mac.login');



// API route for Country Code
Route::get('/getCountryCode', [UserController::class,'getCountryCode'])->name('getCountryCode');

// API route for User Account Create
Route::post('/create-user', [UserController::class,'createUser'])->name('create-user');

// API route for User Email Login
Route::post('/email-login', [UserController::class,'emailLogin'])->name('email-login');

// API route for User Forgot Password
Route::post('forgot-password', [UserController::class,'forgotPassword'])->name('forgot-password');

// API route for User Reset Password
Route::post('reset-password', [UserController::class,'resetPassword'])->name('reset-password');

// API route for Mobile Login
/* API route for Send Otp */
Route::post('sendotp', [UserController::class,'sendotp'])->name('sendotp');

/* API route for Verify Otp */
Route::post('verifyotp', [UserController::class,'verifyOtp'])->name('verifyotp');

// API for User Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    /* API route for User Profile */
    Route::get('/user-profile', function(Request $request) {
        return auth()->user();
    });

    /* API route for User Logout */
    Route::post('/user-logout', [UserController::class, 'logout'])->name('user-logout');
});

// API route for Update Profile
Route::post('updateProfile', [UserController::class,'updateProfile'])->name('updateProfile');

/* API route for Get Banner */
Route::get('getBanner', [UserController::class, 'bannerView'])->name('getBanner');

// for vehicle

Route::get('get-vehicle', [ServiceController::class,'getvehicle'])->name('get-vehicle');
Route::get('viewUserbyid', [UserController::class,'viewUserbyid'])->name('viewUserbyid');
Route::get('findNearestbooking', [UserController::class,'findNearestbooking'])->name('findNearestbooking');
// vehgicle end



/* API route for Get Services */
Route::get('get-service', [ServiceController::class,'getService'])->name('get-service');

Route::get('viewUser', [UserController::class,'viewUser'])->name('get-viewUser');

/* API route for Get Sub Services */
Route::get('get-sub-service', [ServiceController::class,'getSubService'])->name('get-sub-service');

/* API route for Get Condition Question */
Route::get('get-condition-question', [ServiceController::class,'getConditionQuestion'])->name('get-condition-question');

/* API route for Get Services Details */
Route::get('service-details', [ServiceController::class,'getServiceDetails'])->name('service-details');

/* API route for Get Dress Code */
Route::get('getDressCode', [UserController::class, 'getDressCode'])->name('getDressCode');

/* API route for Insert Consition Answer */
Route::post('insert-answer', [UserController::class,'submitAnswer'])->name('insert-answer');

/* API route for booking */

Route::post('serviceBook', [UserController::class,'serviceBook'])->name('serviceBook');


/* API route for After 30 Sec. booking Automatic Cancel */
Route::post('bookingAutoCancel', [UserController::class,'bookingAutoCancel'])->name('bookingAutoCancel');

// API route for status booking accepted
Route::post('bookingAccepted', [UserController::class,'providerBookingAccept'])->name('bookingAccepted');

// API route for Update Booking Status
Route::post('updateBookingStatus', [UserController::class,'updateBookingStatus'])->name('updateBookingStatus');
// API route for Submit Review
Route::post('submitReview', [UserController::class,'submitReview'])->name('submitReview');

// API route for User Invoice
Route::post('userInvoice', [UserController::class,'userInvoice'])->name('userInvoice');

// API route for User Booking History
Route::get('bookingHistory', [UserController::class,'bookingHistory'])->name('bookingHistory');

// API route for User Booking in Details
Route::get('bookingDetails', [UserController::class,'bookingDetail'])->name('bookingDetails');

// API route for User Add Fund in Wallet
Route::post('addFund', [UserController::class,'addFund'])->name('addFund');

// API route for User Wallet History
Route::get('walletHistory', [UserController::class,'walletHistory'])->name('walletHistory');

// API route for User Review
Route::get('userReview', [UserController::class,'userReview'])->name('userReview');

// API route for Get Legal Data
Route::get('/getLegal', [UserController::class,'getPolicy'])->name('getLegal');

Route::get('getCurrencyCode', [UserController::class,'appSetting'])->name('getCurrencyCode');
