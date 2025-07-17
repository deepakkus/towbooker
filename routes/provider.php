<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\ServiceController;
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

Route::middleware('auth:sanctum')->get('/provider-profile', function (Request $request) {
    //return $request->user();
    return auth()->user();
});

/*
|--------------------------------------------------------------------------
| Service Provider Api
|--------------------------------------------------------------------------
*/

/*API route for get country code */
Route::get('getCountryCode', [ServiceProviderController::class,'getCountryCode'])->name('getCountryCode');

/* API route for Get Services */
Route::get('get-service', [ServiceController::class,'getService'])->name('get-service');

/* API route for Get Sub Services */
Route::get('get-sub-service', [ServiceController::class,'getSubService'])->name('get-sub-service');

/* API route for Account Create */
Route::post('/create-provider', [ServiceProviderController::class,'create'])->name('create-provider');

/* API route for Email Login */
Route::post('/email-login', [ServiceProviderController::class,'emailLogin'])->name('email-login');

/* API route for Google Login*/
Route::post('/google-login', [ServiceProviderController::class,'googleLogin'])->name('google-login');

/* API route for Forgot Password */
Route::post('forgot-password', [ServiceProviderController::class,'forgotPassword'])->name('forgot-password');

// API route for Mobile Login
/* API route for Send Otp */
Route::post('sendotp', [ServiceProviderController::class,'sendotp'])->name('sendotp');

/* API route for Verify Otp */
Route::post('verifyotp', [ServiceProviderController::class,'verifyOtp'])->name('verifyotp');

/* API route for Update Profile */
Route::post('update-profile', [ServiceProviderController::class,'updateProfile'])->name('update-profile');

Route::get('getCurrencyCode', [UserController::class,'appSetting'])->name('getCurrencyCode');

// API for Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // API route for Profile
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::get('check-review', [ServiceProviderController::class, 'checkReview'])->name('check-review');
    // API route for logout user
    Route::post('/logout', [ServiceProviderController::class, 'logout'])->name('logout');

    // API route for Provider Booking History
    Route::get('bookingHistory', [ServiceProviderController::class,'bookingHistory'])->name('bookingHistory');
});

// API route for status (offline/online) update
Route::post('updateStatus', [ServiceProviderController::class,'updateStatus'])->name('updateStatus');

// API route for Decline new booking for provider
Route::post('providerDeclineBooking', [ServiceProviderController::class,'providerDeclineBooking'])->name('providerDeclineBooking');

// API route for new booking serching for provider
Route::post('newBooking', [ServiceProviderController::class,'newBooking'])->name('newBooking');
Route::post('cancel-booking', [NotificationController::class, 'cancelBooking'])->name('cancel-booking');
// API route for Accept Booking
Route::post('acceptBooking', [ServiceProviderController::class,'acceptBooking'])->name('acceptBooking');

// API route for Update Booking Status
Route::post('update-booking-status', [ServiceProviderController::class,'updateBookingStatus'])->name('updateBookingStatus');

// API route for Submit Review
Route::post('submitReview', [ServiceProviderController::class,'submitReview'])->name('submitReview');



// API route for User Booking in Details
Route::get('bookingDetails', [ServiceProviderController::class,'bookingDetail'])->name('bookingDetails');

// API route for Get Legal Data
Route::get('/getLegal', [ServiceProviderController::class,'getPolicy'])->name('getLegal');

Route::get('getDate', [ServiceProviderController::class,'getDate'])->name('getDate');

// API route for Provider Wallet History
Route::get('walletHistory', [ServiceProviderController::class,'walletHistory'])->name('walletHistory');

Route::post('withdrawamount', [ServiceProviderController::class,'withdrawamount'])->name('withdrawamount');

Route::post('provider-bid', [ServiceProviderController::class, 'providerBid']);  
Route::post('verify-booking-otp', [ServiceProviderController::class, 'verifyBookingOtp']);
Route::post('upload-after-problem', [ServiceProviderController::class, 'uploadAfterProblem']);
Route::post('upload-signature', [ServiceProviderController::class, 'uploadSignature']); 
Route::get('get-user-booking', [ServiceProviderController::class, 'getUserBooking'])->name('get-user-booking'); 
Route::post('provider-feedback', [ServiceProviderController::class, 'providerFeedback']); 
Route::post('skip-jobs', [ServiceProviderController::class, 'skipJobs'])->name('skip-jobs');
Route::get('get-job-summary', [ServiceProviderController::class, 'getJobSummary'])->name('get-job-summary'); 

Route::middleware('auth:sanctum')->post('update-provider', [ServiceProviderController::class, 'updateProvider']);
Route::get('get-booking-status', [UserController::class, 'getBookingStatus']);
Route::get('get-user-details', [ServiceProviderController::class, 'getUserDetails'])->name('get-user-details');
Route::get('get-user-bookings', [ServiceProviderController::class, 'getUserBookings'])->name('get-user-bookings');

Route::post('delete-provider', [ServiceProviderController::class, 'deleteProvider']); 
Route::post('update-track', [ServiceProviderController::class, 'updateTrack']);
Route::post('withdraw-amount', [ServiceProviderController::class, 'withdrawAmount']);

Route::post('userInvoice', [UserController::class,'userInvoice'])->name('userInvoice');

//API route for otp
Route::post('send-notification', [NotificationController::class, 'sendProviderNotification'])->name('send-notification');
//API route for making payment
Route::post('send-payment-notification', [NotificationController::class, 'sendPaymentNotification'])->name('send-payment-notification');

//API route for job awarded
Route::post('send-job-notification', [NotificationController::class, 'sendJobNotification'])->name('send-job-notification');
//API route for user job notification
Route::post('send-review-notification', [NotificationController::class, 'sendReviewNotification'])->name('send-review-notification');

Route::post('send-messages', [ServiceProviderController::class, 'sendMessages'])->name('send-messages');
Route::get('get-messages', [ServiceProviderController::class, 'fetchMessages'])->name('get-messages');
Route::get('redirect-screen', [ServiceProviderController::class, 'redirectScreen'])->name('redirect-screen');
