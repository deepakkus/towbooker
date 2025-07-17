<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Provider;
use App\Models\SubService;
use App\Models\ConditionQuestion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use DB;
use App\Services\FCMService;
class NotificationController extends Controller
{
    /*
    * User - Send OTP notification to user for login
    *
    */
    public function sendNotification(Request $request, FCMService $fcm)
    {
        $request->validate([
            'code' => 'required|string',
            'mobile_number' => 'required|integer',
            'fcm_token' => 'required|string',
        ]);
        $code = $request->code;
        $mobile = $request->mobile_number;
        $fcm_token = $request->fcm_token;
        if($code == '')
        {
            return response()->json(['status' => '201', 'message' => 'Error, Code Null']);
        }
        else 
        {
            $provider = User::where('country_code',$code)->where('mobile_number' , $mobile)->first();
            try{
                if($provider === null)
                {
                    return response()->json(['status' => '401', 'message' => 'Unauthorized']);
                }
                else
                {
                    $otp = mt_rand(1000, 9999);
                    $provider->otp = $otp;
                    $provider->save();
                    $deviceToken = $fcm_token;
                    $title = 'OTP to login';
                    $body = 'OTP sent via notification - '.$otp;
                    $data = ['custom_key' => 'custom_value'];
                    $data['screen'] = 'OtpLogin';
                    $data['c_code'] = $provider->country_code;
					$data['mobile_number'] = (string)$provider->mobile_number;
					$data['otp'] = (string)$otp;
                    $response = $fcm->sendNotification($deviceToken, $title, $body, $data);
                    $response['otp'] = $otp;
                    $response['title'] = $title;
                    $response['body'] = $body;
                    $response['phoneNumber'] = $mobile;
                    return response()->json(['status' => '200', 'data' => $response], 200);
                    //return response()->json(['status' => '200', 'message' => 'Message Send Successfully','data'=>$otp], 200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }
        }
    
    }
    /*
    *   Provider - Provider OTP notification
    *
    */
    public function sendProviderNotification(Request $request, FCMService $fcm)
    {
        $request->validate([
            'code' => 'required|string',
            'mobile_number' => 'required|integer',
            'fcm_token' => 'required|string',
            'sender_type' => 'required|string'
        ]);
        $code = $request->code;
        $mobile = $request->mobile_number;
        $fcm_token = $request->fcm_token;
        $sender_type = $request->sender_type;
        $provider = Provider::where('country_code',$code)->where('mobile_number' , $mobile)->first();
        try{
            if($provider === null)
            {
                return response()->json(['status' => '401', 'message' => 'Unauthorized']);
            }
            else
            {
                $otp = mt_rand(1000, 9999);
                $provider->otp = $otp;
                $provider->save();
                $deviceToken = $fcm_token;
                $title = 'OTP to login';
                $body = 'OTP sent via notification - '.$otp;
                $data = ['custom_key' => 'custom_value'];
                $data['screen'] = 'OtpLoginScreen';
                $data['c_code'] = $provider->country_code;
				$data['mobile_number'] = (string)$provider->mobile_number;
				$data['otp'] = (string)$otp;
                $response = $fcm->sendNotification($deviceToken, $title, $body, $data, $sender_type);
                $response['otp'] = $otp;
                $response['title'] = $title;
                $response['body'] = $body;
                $response['phoneNumber'] = $mobile;
                return response()->json(['status' => '200', 'data' => $response], 200);
            }
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    /*
    *   User - Send notification for bid placed
    *
    */
    public function sendBidNotification(Request $request, FCMService $fcm)
    {
        
        $request->validate([
            'booking_id' => 'required|string',
            'fcm_token' => 'required|string',
        ]);
        $fcm_token = $request->fcm_token;
        $providers = '';
        try
        {
            $providerSearch = DB::table('booking_provider_search')
                ->join('bookings', 'booking_provider_search.booking_id', '=', 'bookings.booking_id')
                ->join('providers', 'booking_provider_search.provider_id', '=', 'providers.id')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->join('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                ->where('booking_provider_search.booking_id', $request->booking_id)
                ->where('booking_provider_search.bid_placed', 1)
                ->where('bookings.status', 'SEARCHING')
                ->select(
                    'providers.id',
                    'providers.first_name',
                    'providers.last_name',
                    'providers.email',
                    'providers.mobile_number',
                    'providers.profile_picture',
                    'providers.rating',
                    'providers.business_name',
                    'providers.business_address',
                    'providers.business_type',
                    'providers.service_type',
                    'booking_provider_search.price',
                    'booking_provider_search.distance',
                    'booking_provider_search.booking_id',
                    'booking_provider_search.bid_placed',
                    'services.id as catid',
					'services.title as category',
					'sub_services.id as sub_cat_id',
					'sub_services.title as sub_category'
                )
                ->get();

            if ($providerSearch->isEmpty()) {
                return response()->json([
                    'status' => '200',
                    'message' => 'No providers found for your searching bookings',
                    'data' => []
                ]);
            }
            $deviceToken = $fcm_token;
            $title = 'Provider placed bid';
            $body = 'Bid placed sent via notification by providers - ';
            $count = count($providerSearch);
            foreach($providerSearch as $key => $provider)
            {
                $catid = $provider->catid;
				$category = $provider->category;
				$sub_catid = $provider->sub_cat_id;
				$sub_category = $provider->sub_category;
                if ($key == $count - 1 && $count>1) {
                    $providers = rtrim($providers, ",");
                    $providers .= ' and ' . $provider->first_name . ' ' . $provider->last_name;
                } else {
                    $providers .= $provider->first_name . ' ' . $provider->last_name . ',';
                }
            }
            $body .= $providers;
            $data = ['custom_key' => 'custom_value'];
            $data['screen'] = 'NearbyDriversScreen';
			$data['bookingId'] = $request->booking_id;
			$data['selectedCatID'] = $catid;
			$data['selectedCategory'] = $category;
			$data['selectedSubCatID'] = $sub_catid;
			$data['selectedSubCategory'] = $sub_category;
            $response = $fcm->sendNotification($deviceToken, $title, $body, $data);
            $response['body'] = $body;
            $response['title'] = $title;
            $response['providers'] = $providerSearch;
            return response()->json(['status' => '200', 'data' => $response], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    /*
    *   Provider - Send notification for user payment
    * 
    */
    public function sendPaymentNotification(Request $request, FCMService $fcm)
    {
        // $request->validate([
        //     'booking_id' => 'required|string',
        //     'fcm_token' => 'required|string',
        //     'sender_type' => 'required|string'
        // ]);

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            //'pid' => 'required|exists:booking_provider_search,provider_id',
            'fcm_token' => 'required|string',
            'sender_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        $fcm_token = $request->fcm_token;
        $sender_type = $request->sender_type;
        try
        {
            $booking = Booking::where('booking_id', $request->booking_id)
                ->where('paid', 1)
                ->first();
            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }
            $user = $booking->user;
           
            $deviceToken = $fcm_token;
            $title = 'Payment Successful';
            $body = 'The user has completed a payment.';
            $data = ['custom_key' => 'custom_value'];
            $data['screen'] = 'WorkSummary';
			$data['firstName'] = $user->first_name;
			$data['lastName'] = $user->last_name;
			$data['s_latitude'] = (string)$booking->s_latitude;
			$data['s_longitude'] = (string)$booking->s_longitude;
			$data['price'] = (string)$booking->amount;
			$data['distance'] = (string)$booking->distance;
			$data['bookingId'] = $request->booking_id;
            if($booking)
            {
                //$booking->provider_status = 'COMPLETED';
                $booking->save();
                $response = $fcm->sendNotification($deviceToken, $title, $body, $data, $sender_type);
                $response['body'] = $body;
                $response['title'] = $title;
                
                return response()->json(['status' => '200', 'data' => $response], 200);
            }
            
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
        
    }
    /*
    *   Notification sent for jaob awarded
    *
    */
    public function sendJobNotification(Request $request, FCMService $fcm)
    {
        $request->validate([
            'booking_id' => 'required|string',
            'fcm_token' => 'required|string',
            'sender_type' => 'required|string'
        ]);
        $fcm_token = $request->fcm_token;
        $sender_type = $request->sender_type;
        try
        {
            $booking = Booking::where('booking_id', $request->booking_id)
                ->join('providers', 'bookings.provider_id', '=', 'providers.id')
				->join('users', 'bookings.user_id', '=', 'users.id')
                ->where('bookings.status', 'CONFIRMED')
                ->select('providers.id', 
				'providers.first_name',
				'providers.last_name',
				'users.first_name as user_first_name',
				'users.last_name as user_last_name',
				'bookings.s_latitude',
				'bookings.s_longitude',
				'bookings.distance',
				'bookings.amount'
				)
                ->first();
            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }
            $providerSearch = DB::table('booking_provider_search')
                ->join('providers', 'booking_provider_search.provider_id', '=', 'providers.id')
                ->where('booking_provider_search.booking_id', $request->booking_id)
                ->where('booking_provider_search.provider_id', '!=', $booking->id)
                ->where('booking_provider_search.bid_placed', 1)
                ->select('providers.id', 'providers.first_name', 'providers.last_name')
                ->get();
             
            $deviceToken = $fcm_token;
            $title = 'Provider Job notification';
            $body = 'Sent notification for Job awarded to provider - '.$booking->first_name.' '.$booking->last_name;
            $data = ['custom_key' => 'custom_value'];
            $data['screen'] = 'ProviderStatus';
			$data['firstName'] = $booking->user_first_name;
			$data['lastName'] = $booking->user_last_name;
			$data['s_latitude'] = (string)$booking->s_latitude;
			$data['s_longitude'] = (string)$booking->s_longitude;
			$data['price'] = (string)$booking->amount;
			$data['distance'] = $booking->distance;
            $data['bookingId'] = $request->booking_id;
            $response = $fcm->sendNotification($deviceToken, $title, $body, $data, $sender_type);
            $response['body'] = $body;
            $response['title'] = $title;
             // Notify all other providers who placed a bid (rejected ones)
            foreach ($providerSearch as $provider) {
                // Get FCM token for each provider (assuming you store it in a table)
                $providerFcmToken = Provider::where('id', $provider->id)
                    ->value('device_token'); // Or first()->fcm_token if you want to handle multiple tokens

                if ($providerFcmToken) {
                    $rejectionBody = 'Job was awarded to another provider: ' . $booking->first_name . ' ' . $booking->last_name;
                    $fcm->sendNotification($providerFcmToken, $title, $rejectionBody, $data, $sender_type);
                }
            }
            //return response()->json(['status' => '200',  'message' => 'Notifications sent successfully',  'awarded_provider' => $booking,  'other_providers' => $providerSearch], 200);
            return response()->json(['status' => '200', 'data' => $response], 200);
			
			//return response()->json(['status' => '200', 'data' => $response, 'p' => $providerSearch], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    /*
    *   User - Send payment notification
    *
    */
    public function sendUserPaymentNotification(Request $request, FCMService $fcm)
    {
        $request->validate([
            'booking_id' => 'required|string',
            'fcm_token' => 'required|string',
        ]);
        
        $fcm_token = $request->fcm_token;
        try{
            $booking = Booking::where('booking_id', $request->booking_id)
                ->where('bookings.paid', 1)
                ->first();
            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }
            $deviceToken = $fcm_token;
            $title = 'Provider Job notification';
            $body = 'User made payment sent via notification';
            $data = ['custom_key' => 'custom_value'];
            $data['screen'] = 'UserRatingScreen';
            $data['booking_id'] = $request->booking_id;
            $response = $fcm->sendNotification($deviceToken, $title, $body, $data);
            $response['body'] = $body;
            $response['title'] = $title;
            return response()->json(['status' => '200', 'data' => $response], 200);
            
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    /*
    * Cancel job
    */
    public function cancelBooking(Request $request, FCMService $fcm)
    {
        try{
			
			// Validate the request
           
			$request->validate([
				'booking_id' => 'required|string',
				'fcm_token' => 'required|string',
				'cancel_reason' => 'required|string',
                'cancel_by' => 'required|string',
				'sender_type' => 'required|string'
			]);
			$fcm_token = $request->fcm_token;
			$sender_type = $request->sender_type;
			// Find the booking
            $booking = Booking::where('booking_id', $request->booking_id)
                            ->where('status', '!=', 'COMPLETED')
                            ->where('status', '!=', 'SEARCHING')
                            ->first();
            //$user = $booking->user;                

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found or cannot be cancelled (completed or searching bookings cannot be cancelled)'
                ], 404);
            }
            
             // Update booking status
            $booking->status = 'CANCELLED';
            $booking->user_status = 'CANCELLED';
            $booking->provider_status = 'CANCELLED';
            $booking->cancel_reason = $request->cancel_reason;
            $booking->cancelled_by = $request->cancel_by;
            $booking->save();
			$deviceToken = $fcm_token;
            $title = 'Cancel Job notification';
            $body = 'Job Cancelation sent via notification';
            $data = ['custom_key' => 'custom_value'];
			$data['screen'] = '';
			$data['booking_id'] = $request->booking_id;
			/*$data['firstName'] = $booking->user_first_name;
			$data['lastName'] = $booking->user_last_name;
			$data['s_latitude'] = (string)$booking->s_latitude;
			$data['s_longitude'] = (string)$booking->s_longitude;
			$data['price'] = (string)$booking->amount;
			$data['distance'] = $booking->distance;*/
            $response = $fcm->sendNotification($deviceToken, $title, $body, $data, $sender_type);
            $response['body'] = $body;
            $response['title'] = $title;
            return response()->json(['status' => '200', 'data' => $response], 200);
		}
		catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    /*
    *  
    *
    */
     public function sendReviewNotification(Request $request, FCMService $fcm) {
		 
		 try{
			 $request->validate([
				'booking_id' => 'required|string',
				'fcm_token' => 'required|string',
				'sender_type' => 'required|string'
			]);
			$fcm_token = $request->fcm_token;
			$sender_type = $request->sender_type;
			 // Find the booking
            $booking = Booking::where('booking_id', $request->booking_id)
				->whereNotNull('user_review')
				->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'No review found for this booking'
                ], 404);
            }
			
		
            
			$deviceToken = $fcm_token;
            $title = 'User Review notification';
            $body = 'User review received via notification. Please see the review:'.$booking->user_review;
            $data = ['custom_key' => 'custom_value'];
			$data['screen'] = '';
			$data['booking_id'] = $request->booking_id;
            $response = $fcm->sendNotification($deviceToken, $title, $body, $data, $sender_type);
            $response['body'] = $body;
            $response['title'] = $title;
            return response()->json(['status' => '200', 'data' => $response], 200);
		 }
		 catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
	 }
}
