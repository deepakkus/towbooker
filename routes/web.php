<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProviderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SubServiceController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DressCodeController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\ProviderResetPasswordController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/



Route::get('admin', [AdminAuthController::class,'index'])->name('admin');
Route::get('admin/login', [AdminAuthController::class,'adminLogin'])->name('admin.login');
Route::post('admin/loginn', [AdminAuthController::class,'adminLogin'])->name('admin.loginn');
Route::get('admin/logout', [AdminAuthController::class,'logout'])->name('admin.logout');
Route::get('provider/reset-password/{token}', [ProviderResetPasswordController::class, 'showResetForm'])
    ->name('provider.password.reset');
Route::post('provider/reset-password', [ProviderResetPasswordController::class, 'reset'])->name('provider.password.update');    
Route::get('/provider/dashboard', [ProviderResetPasswordController::class, 'index'])->middleware('auth:provider')
    ->name('provider.dashboard'); 

Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
	// Admin Dashboard
	Route::get('dashboard', [AdminAuthController::class,'dashboard'])->name('admin.dashboard');
	
	// Admin Profile
	Route::get('profile', [AdminAuthController::class,'profile'])->name('admin.profile');
	
	//Update Admin Profile
	Route::post('updateProfile', [AdminAuthController::class,'updateProfile'])->name('admin.updateProfile');
	
	// Change Password Screen
	Route::get('changePassword', [AdminAuthController::class,'changePassword'])->name('admin.changePassword');
	
	// Update Admin Password
	Route::post('updatePassword', [AdminAuthController::class,'updatePassword'])->name('admin.updatePassword');
	// App Setting
	Route::get('appsetting', [AppSettingController::class,'appsetting'])->name('admin.appsetting');
	Route::get('viewname', [ProviderController::class,'viewname'])->name('admin.viewname');



// document for provider

Route::get('provider/document/{id}', [ProviderController::class,'providerprovider'])->name('admin.provider.provider');

Route::post('pppppppppprovider', [ProviderController::class,'providerdocumentupdate'])->name('admin.provider.document.update');


// end document for provider



	
	// Update App Setting
	Route::post('appsetting/update/{id}', [AppSettingController::class,'updateAppSetting'])->name('admin.updateAppSetting');
	
	//** ------ User Start ------ **//
	// User List
	Route::get('user', [UserController::class,'index'])->name('admin.user');
	// Add User Screen
	Route::get('user/create', [UserController::class,'create'])->name('admin.user.create');
	// Store User
	Route::post('user/store', [UserController::class,'store'])->name('admin.user.store');
	// Update User Status
	Route::get('user/update/status', [UserController::class,'updateStatus'])->name('admin.user.updateStatus');
	// Edit User Screen
	Route::get('user/edit/{id}', [UserController::class,'edit'])->name('admin.user.edit');
	// Update User
	Route::post('user/update/{id}', [UserController::class,'update'])->name('admin.user.update');
	// Soft Delete User
	Route::get('user/delete/{id}', [UserController::class,'delete'])->name('admin.user.delete');
	Route::get('user/import', [UserController::class,'bulkImport'])->name('admin.user.import');
	Route::post('user/import/store', [UserController::class,'bulkImportStore'])->name('admin.user.import.store');
	Route::get('user/bookingHistory/{id}', [UserController::class,'bookingHistory'])->name('admin.user.bookingHistory');
	//** ------ User End ------ **//
	
	//** ------ Provider Start ------ **//
	// Provider List
	Route::get('provider', [ProviderController::class,'index'])->name('admin.provider');
	// Add Provider Screen
	Route::get('provider/create', [ProviderController::class,'create'])->name('admin.provider.create');
	// Store Provider
	Route::post('provider/store', [ProviderController::class,'store'])->name('admin.provider.store');
	// Bulk Import Screen
	Route::get('provider/import', [ProviderController::class,'bulkImport'])->name('admin.provider.import');
	// Bulk Import Store
	Route::post('provider/import/store', [ProviderController::class,'bulkImportStore'])->name('admin.provider.import.store');
	Route::get('provider/withdrawal/pending', [ProviderController::class,'pendingRequest'])->name('admin.provider.withdrawal.pending');
	Route::get('provider/withdrawal/approve', [ProviderController::class,'approveRequest'])->name('admin.provider.withdrawal.approve');
	Route::get('provider/withdrawal/decline', [ProviderController::class,'declineRequest'])->name('admin.provider.withdrawal.decline');
	Route::get('provider/withdrawalStatus/{id}/{status}', [ProviderController::class,'updateWithdrawStatus'])->name('admin.provider.withdrawalStatus');
	//** ------ Provider End ------ **//
	
	//** ------ Site Setting Start ------ **//
	// Legal Screen
	Route::get('legal', [AdminController::class,'legal'])->name('admin.legal');
	
	// Update Legal
	Route::post('updateLegal/{id}', [AdminController::class,'updateLegal'])->name('admin.updateLegal');
	
	// Commission
	Route::get('commission',[AdminController::class,'commission'])->name('admin.commission');
	
	// Update Commission
	Route::post('updateCommission/{id}', [AdminController::class,'updateCommission'])->name('admin.updateCommission');
	
	//** ------ Site Setting End ------ **//
	
	//** ------ Start Services ------ **//
	// Add Service Screen
	Route::get('service/addService', [ServiceController::class,'addService'])->name('admin.service.addService');
	// Store Service
	Route::post('service/storeService', [ServiceController::class,'storeService'])->name('admin.service.storeService');
	// Service List
	Route::get('service/serviceList', [ServiceController::class,'serviceList'])->name('admin.service.serviceList');
	// Update Service Status
	Route::get('service/updateServiceStatus', [ServiceController::class,'changeServiceStatus'])->name('admin.service.updateServiceStatus');
	// Edit Service Screen
	Route::get('service/editService/{id}', [ServiceController::class,'editService'])->name('admin.service.editService');
	// Update Service
	Route::post('service/updateService/{id}', [ServiceController::class,'updateService'])->name('admin.service.updateService');
	
	Route::post('status/update/store', [ServiceController::class,'statusupdatestore'])->name('status.update.store');
	
	// Delete Service
	Route::get('service/deleteService/{id}', [ServiceController::class,'deleteService'])->name('admin.service.deleteService');
	// Service Bulk Import Screen
	Route::get('service/import', [ServiceController::class,'bulkServiceImport'])->name('admin.service.import');
	// Service Bulk Import Store
	Route::post('service/import/store', [ServiceController::class,'bulkServiceStore'])->name('admin.service.import.store');
	
	
	// Add Sub Service Screen
	Route::get('service/addSubService', [SubServiceController::class,'addSubService'])->name('admin.service.addSubService');
	// Store Sub Service
	Route::post('service/storeSubService', [SubServiceController::class,'storeSubService'])->name('admin.service.storeSubService');
	// Sub Service List
	Route::get('service/subServiceList', [SubServiceController::class,'subServiceList'])->name('admin.service.subServiceList');
	// Update Sub Service Status
	Route::get('service/updateSubServiceStatus', [SubServiceController::class,'changeSubServiceStatus'])->name('admin.service.updateSubServiceStatus');
	// Edit Sub Service Screen
	Route::get('service/editSubService/{id}', [SubServiceController::class,'editSubService'])->name('admin.service.editSubService');
	// Update Sub Service
	Route::post('service/updateSubService/{id}', [SubServiceController::class,'updateSubService'])->name('admin.service.updateSubService');
	// Delete Sub Service
	Route::get('service/deleteSubService/{id}', [SubServiceController::class,'deleteSubService'])->name('admin.service.deleteSubService');
	//** ------ End Services ------ **//


	//** ------ Start Question ------ **//
	// Question List
	Route::get('question', [QuestionController::class,'index'])->name('admin.question');
	// Question Create
	Route::get('question/create', [QuestionController::class,'create'])->name('admin.question.create');
	// Get Sub Service
	Route::post('question/getSubService', [QuestionController::class,'getSubService'])->name('admin.question.getSubService');
	// Question Store
	Route::post('question/store', [QuestionController::class,'store'])->name('admin.question.store');
	// Update Question Status
	Route::get('question/update/status', [QuestionController::class,'updateStatus'])->name('admin.question.updateStatus');
	// Edit Question Screen
	Route::get('question/edit/{id}', [QuestionController::class,'edit'])->name('admin.question.edit');
	// Update Question
	Route::post('question/update/{id}', [QuestionController::class,'update'])->name('admin.question.update');
	// Soft Delete Question
	Route::get('question/delete/{id}', [QuestionController::class,'delete'])->name('admin.question.delete');
	//** ------ End Question ------ **//
	
	
	//** ------ Start Dress Code ------ **//
	// Dress Code List
	Route::get('dress', [DressCodeController::class,'index'])->name('admin.dress');
	// Update Dress Code Status
	Route::get('dress/update/status', [DressCodeController::class,'updateStatus'])->name('admin.dress.updateStatus');
	// Edit Dress Code Screen
	Route::get('dress/edit/{id}', [DressCodeController::class,'edit'])->name('admin.dress.edit');
	// Update Question
	Route::post('dress/update/{id}', [DressCodeController::class,'update'])->name('admin.dress.update');
	//** ------ End Dress Code ------ **//
	
	
	//** ------ Start Review ------ **//
	// User Review List
	Route::get('review/user', [ReviewController::class,'index'])->name('admin.review.user');
	//** ------ End Review ------ **//
	
	
	//** ------ Start Banner ------ **//
	// Banner Edit
	Route::get('banner/edit', [BannerController::class,'edit'])->name('admin.banner.edit');
	// Update Banner
	Route::post('banner/update/{id}', [BannerController::class,'update'])->name('admin.banner.update');
	//** ------ End Review ------ **//
	
	
	
// 	vehicle start here
	Route::post('admin/vehicle/store', [UserController::class,'vehiclestore'])->name('admin.vehicle.add');

	Route::post('admin/vehicle/update', [UserController::class,'vehicleupdate'])->name('admin.vehicle.update');

	Route::get('admin/vehicle', [UserController::class,'vehicle'])->name('admin.vehicle');
		Route::get('admin/vehicle/list/', [UserController::class,'vehiclelist'])->name('admin.vehicle.list');
		
		Route::get('admin/vehicle/edit/{id}', [UserController::class,'vehicleedit'])->name('admin.vehicle.edit');
			Route::get('admin/vehicle/delete/{id}', [UserController::class,'vehicledelete'])->name('admin.vehicle.delete');




// vehicle end here
	
	
	
	
	
	// Booking History
	Route::get('bookingHistory', [AdminController::class,'bookingHistory'])->name('admin.bookingHistory');
	
	
		Route::get('Existing-Cancelled-Booking', [AdminController::class,'existingcanceelledbooking'])->name('admin.existingcanceelledbooking');
		
		Route::get('getajaxdata', [AdminController::class,'getajaxdata'])->name('admin.getajaxdata');
	
			Route::get('completeview', [UserController::class,'completeview'])->name('admin.completeview');

	
	Route::get('bookingDetail/{id}', [AdminController::class,'bookingDetail'])->name('admin.bookingDetail');
});


Route::get('userhistoryyy/{id}', [UserController::class,'userhistoryyy'])->name('admin.userhistoryyy');
Route::get('deleteproviderr/{id}', [ProviderController::class,'deleteproviderr'])->name('admin.deleteproviderr');
Route::get('bookingdelete/{id}', [AdminController::class,'bookingdelete'])->name('admin.bookingdelete');

Route::get('userhistoryyy/{id}', [UserController::class,'userhistoryyy'])->name('admin.userhistoryyy');


Route::post('cancelledeBookingStatus', [UserController::class,'cancelledeBookingStatus'])->name('cancelledeBookingStatus');

Route::post('updateprovider', [ProviderController::class,'updateprovider'])->name('provider.updateprovider');

Route::get('editprovider/{id}', [ProviderController::class,'editprovider'])->name('admin.editprovider');



Route::get('servicesubservice', [AdminController::class,'servicesubservice'])->name('admin.servicesubservice');
Route::get('servicesubbservice', [AdminController::class,'servicesubbservice'])->name('admin.servicesubbservice');


Route::get('subservicedata', [AdminController::class,'subservicedata'])->name('admin.subservicedata');



	Route::post('bookingservice', [UserController::class,'bookingservice'])->name('admin.bookingservice');

