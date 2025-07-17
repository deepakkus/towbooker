<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Admin\ProviderController;


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
| Service Provider Api
|--------------------------------------------------------------------------
*/

// provider booking accept notification
Route::get('StatusAcceptedNotification', [ServiceProviderController::class,'StatusAcceptedNotification'])->name('StatusAcceptedNotification');
Route::get('StatusArrivedNotification', [ServiceProviderController::class,'StatusArrivedNotification'])->name('StatusArrivedNotification');
Route::get('StatusStratedNotification', [ServiceProviderController::class,'StatusStratedNotification'])->name('StatusStratedNotification');
Route::get('StatusCompletedNotification', [ServiceProviderController::class,'StatusCompletedNotification'])->name('StatusCompletedNotification');
Route::get('StatusDroppeddNotification', [ServiceProviderController::class,'StatusDroppeddNotification'])->name('StatusDroppeddNotification');





Route::get('walletHistory', [UserController::class,'walletHistory'])->name('walletHistory');

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

/* API route for Forgot Password */
Route::post('forgot-password', [ServiceProviderController::class,'forgotPassword'])->name('forgot-password');

// API route for Mobile Login
/* API route for Send Otp */
Route::post('sendotp', [ServiceProviderController::class,'sendotp'])->name('sendotp');

/* API route for Verify Otp */
Route::post('verifyotp', [ServiceProviderController::class,'verifyOtp'])->name('verifyotp');

/* API route for Update Profile */
Route::post('update-profile', [ServiceProviderController::class,'updateProfile'])->name('update-profile');

// API for Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // API route for Profile
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    // API route for logout user
    Route::post('/logout', [ServiceProviderController::class, 'logout'])->name('logout');
});

// API route for status (offline/online) update
Route::post('updateStatus', [ServiceProviderController::class,'updateStatus'])->name('updateStatus');

// API route for Decline new booking for provider
Route::post('providerDeclineBooking', [ServiceProviderController::class,'providerDeclineBooking'])->name('providerDeclineBooking');

// API route for new booking serching for provider
Route::post('newBooking', [ServiceProviderController::class,'newBooking'])->name('newBooking');

// API route for Accept Booking
Route::post('acceptBooking', [ServiceProviderController::class,'acceptBooking'])->name('acceptBooking');

// API route for Update Booking Status
Route::post('updateBookingStatus', [ServiceProviderController::class,'updateBookingStatus'])->name('updateBookingStatus');

// API route for Update Track Location
Route::post('updateTrack', [ServiceProviderController::class,'updateTrack'])->name('updateTrack');

// API route for Submit Review
Route::post('submitReview', [ServiceProviderController::class,'submitReview'])->name('submitReview');

// API route for Provider Booking History
Route::get('bookingHistory', [ServiceProviderController::class,'bookingHistory'])->name('bookingHistory');

// API route for Get Legal Data
Route::get('/getLegal', [ServiceProviderController::class,'getPolicy'])->name('getLegal');

Route::get('getDate', [ServiceProviderController::class,'getDate'])->name('getDate');


// API route for User Review
Route::get('providerReview', [ServiceProviderController::class,'providerReview'])->name('providerReview');

Route::post('withdrawamount', [ServiceProviderController::class,'withdrawamount'])->name('withdrawamount');






Route::get('getappname',[ProviderController::class,'getappname'])->name('getappname');

