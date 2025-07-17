<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StripePaymentController;
use App\Http\Controllers\Api\NotificationController;

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
    Route::get('check-review', [UserController::class, 'checkReview'])->name('check-review');
    /* API route for User Logout */
    Route::post('/user-logout', [UserController::class, 'logout'])->name('user-logout');

    
});

// API route for Update Profile
Route::post('updateProfile', [UserController::class,'updateProfile'])->name('updateProfile');

/* API route for Get Banner */
Route::get('getBanner', [UserController::class, 'bannerView'])->name('getBanner');

/* API route for Get Services */
Route::get('get-service', [ServiceController::class,'getService'])->name('get-service');

/* API route for Get Sub Services */
Route::get('get-sub-service', [ServiceController::class,'getSubService'])->name('get-sub-service');

/* API route for Get Condition Question */
Route::get('get-condition-question', [ServiceController::class,'getConditionQuestion'])->name('get-condition-question');

/* API route for Get Nearby Provider List*/
Route::get('findNearestbooking', [UserController::class,'findNearestbooking'])->name('findNearestbooking');

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

Route::post('update-fields', [UserController::class,'updateFields'])->name('update-fields');
// API route for Update Booking Status
Route::post('updateBookingStatus', [UserController::class,'updateBookingStatus'])->name('updateBookingStatus');

// API route for Submit Review
Route::post('submitReview', [UserController::class,'submitReview'])->name('submitReview');

// API route for User Invoice
Route::post('userInvoice', [UserController::class,'userInvoice'])->name('userInvoice');

Route::post('upload-vehicle-image', [ServiceController::class, 'uploadVehicleImage'])->name('upload-vehicle-image');
// API route for User Booking History
Route::get('bookingHistory', [UserController::class,'bookingHistory'])->name('bookingHistory');

// API route for User Booking in Details
Route::get('bookingDetails', [UserController::class,'bookingDetail'])->name('bookingDetails');

// API route for User Add Fund in Wallet
Route::post('addFund', [UserController::class,'addFund'])->name('addFund');

// API route for User Wallet History
Route::get('walletHistory', [UserController::class,'walletHistory'])->name('walletHistory');

Route::get('userReview', [UserController::class,'userReview'])->name('userReview');

// API route for Get Legal Data
Route::get('/getLegal', [UserController::class,'getPolicy'])->name('getLegal');

Route::get('getCurrencyCode', [UserController::class,'appSetting'])->name('getCurrencyCode');

Route::post('user_confirm_provider', [UserController::class, 'userConfirmProvider']);
Route::post('user-feedback', [UserController::class, 'userFeedback']);
Route::get('get-providers', [UserController::class, 'getProviders'])->name('get-providers');

Route::get('get-booking-status', [UserController::class, 'getBookingStatus']);
Route::get('get-job-summary', [UserController::class, 'getJobSummary'])->name('get-job-summary');
Route::get('get-provider-details', [UserController::class, 'getProviderDetails'])->name('get-provider-details');
//Route::post('update-user-feedback', [UserController::class, 'updateUserFeedback']);
Route::post('delete-user', [UserController::class, 'deleteUser']);
Route::post('create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
Route::post('credit-card-payment', [StripePaymentController::class, 'chargeCard']);
Route::post('update-user-payment', [App\Http\Controllers\Api\UserController::class, 'updateUserPayment']);
Route::get('get-provider-tracker', [App\Http\Controllers\Api\UserController::class, 'getProviderTracker']);
Route::post('cancel-booking', [UserController::class, 'cancelBooking'])->name('cancel-booking');

// API route for Update Wallet
Route::post('update-wallet', [UserController::class, 'updateWallet'])->name('update-wallet');

Route::post('send-notification', [NotificationController::class, 'sendNotification'])->name('send-notification');
//API route for Provider Placed Bid Notification
Route::post('send-bid-notification', [NotificationController::class, 'sendBidNotification'])->name('send-bid-notification');
//API route for payment notification
Route::post('send-payment-notification', [NotificationController::class, 'sendUserPaymentNotification'])->name('send-payment-notification');

Route::post('send-messages', [UserController::class, 'sendMessages'])->name('send-messages');

Route::get('get-messages', [UserController::class, 'fetchMessages'])->name('get-messages');
Route::get('redirect-screen', [UserController::class, 'redirectScreen'])->name('redirect-screen');
