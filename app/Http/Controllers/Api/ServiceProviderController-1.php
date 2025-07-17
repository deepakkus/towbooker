<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\Otp;
use App\Models\Country;
use App\Models\Booking;
use App\Models\Policy;
use App\Models\Withdrawal;
use App\Models\ProviderDeclineBooking;
use App\Models\UserWalletHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use DB;

class ServiceProviderController extends Controller
{
    /** For Country Phone Code Start **/
    public function getCountryCode()
    {
        $code = Country::all();
        return response()->json(['status' => '200', 'message' => 'Country Code','data' => $code]);
    }
    /** For Country Phone Code End **/
    
    /** For Create Account Start **/
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',

            'email' => 'required|string|email|max:255|unique:providers',
            'country_code' => 'required',
            'mobile_number' => 'required|unique:providers',
            'password' => 'required|string|min:8'
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = Provider::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'mobile_number' => $request->mobile_number,
            'fcm_token' => $request->fcm_token,
            'postcode' => $request->postcode,
            'sia_license' => $request->sia_license,
            'password' => Hash::make($request->password),
            'business_name' => $request->business_name,
            'incorporation_no' => $request->incorporation_no,
            'business_address' => $request->business_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'business_type' => $request->business_type,
            'service_type' => $request->service_type,
            'device_token' => $request->device_token,
            
            
            
            
            
        ]);
         
         if($request->driving_license != $user->driving_license)
            {
                $image = $request->driving_license;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/admin/images/drivinglicense/' . $imageName, base64_decode($image2));
                $user->driving_license = url('public/admin/images/drivinglicense/'.$imageName);
            }
            
         
         
        if($request->experiance_letter != $user->experiance_letter)
            {
                $image = $request->experiance_letter;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/admin/images/experienceletter/' . $imageName, base64_decode($image2));
                $user->experiance_letter = url('public/admin/images/experienceletter/'.$imageName);
            }
            
            
            if($request->idproofff != $user->id_proof)
            {
                $image = $request->idproofff;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/admin/images/idproof/' . $imageName, base64_decode($image2));
                $user->id_proof = url('public/admin/images/idproof/'.$imageName);
            }
            
            
   if($request->add_proof != $user->address_proof)
            {
                $image = $request->add_proof;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/admin/images/addressproof/' . $imageName, base64_decode($image2));
                $user->address_proof = url('public/admin/images/addressproof/'.$imageName);
            }
            
   if($request->rc_card != $user->rc_card)
            {
                $image = $request->rc_card;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/admin/images/registrationcard/' . $imageName, base64_decode($image2));
                $user->rc_card = url('public/admin/images/registrationcard/'.$imageName);
            }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => '200', 'message' => 'Provider Register Successfully', 'data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);   
    }
    /** For Create Account End **/
    
    /** For Email Login Start **/
    public function emailLogin(Request $request)
    {
        if (!Auth::guard('provider')->attempt($request->only('email', 'password')))
        {
            return response()->json(['status' => '401', 'message' => 'Unauthorized']);
        }
        
        $user = Provider::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', ]);
    }
    /** For Email Login End **/
    
    /** For Forgot Password Start **/
    public function forgotPassword(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email|exists:users,email"
        ]);
        if ($validator->fails())
        {
            return response(['status' => '422', 'message'=>$validator->errors()->all()]);
        }
        $response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT)
        {
            $message = "Mail send successfully";
        }else
        {
            $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        return response()->json(['status' => '200', 'data'=>'','message' => $message]);
    }
    /** For Forgot Password End **/
    
    /** For Mobile Login Start **/
    /* Send Otp */
    public function sendotp(Request $request)
    {
        $code = $request->code;
        $mobile = $request->mobile_number;
        
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
                return response()->json(['status' => '200', 'message' => 'Message Send Successfully', 'data' => $otp]);
            }
        }
        catch(Exception $e)
        {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }
    
    /* Verify Otp */
    public function verifyOtp(Request $request)
    {
        $code = $request->code;
        $mobile = $request->mobile_number;
        $otp = $request->otp;
        $otpCheck = Provider::where('country_code',$code)->where('mobile_number',$mobile)->where('otp',$otp)->orderBy('id','DESC')->first();
        if($otpCheck === null)
        {
            return response()->json(['status' => '404', 'message' => 'Wrong Otp']);
        }
        else
        {
            $user = Provider::where('country_code',$code)->where('mobile_number', $mobile)->firstOrFail();
            $user->otp = "0";
            $user->device_token= $request->token;
            $user->save();
            
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', ]);
        }
    }
    /** For Mobile Login End **/
    
    /** For Update Profile Start **/
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
        ]);
        
        $provider = Provider::findOrFail($request->id);
        $provider->first_name = $request->first_name;
        $provider->last_name = $request->last_name;
        $provider->abn_number = $request->abn_number;
        if($request->profile_picture != '')
        {
            $image = $request->profile_picture;  // your base64 encoded
            $image1 = str_replace('data:image/png;base64,', '', $image);
            $image2 = str_replace(' ', '+', $image1);
            $imageName = time().'.'.'png';
            $path = \File::put(public_path().'/images/' . $imageName, base64_decode($image2));
            $provider->profile_picture = url('public/images/'.$imageName);
        }
        $provider->save();
        
        return response()->json(['status' => '200', 'message' => 'Profile Update Successfully', 'data' => $provider]);
    }
    /** For Update Profile End **/
    
    /** For Logout Start **/
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['status' => '200', 'message' => 'You have successfully logged out and the token was successfully deleted']);
    }
    /** For Logout End **/
    
    /** For Provider Offline/Online Start **/
    public function updateStatus(Request $request)
    {
        $provider = Provider::findOrFail($request->id);
        if($provider->status == '0')
        {
            $provider->status = '1';
        }
        else
        {
            $provider->status = '0';
        }
        $provider->save();
        
        return response()->json(['status' => '200', 'message' => 'Status Update Successfully', 'data' => $provider->status]);
    }
    /** For Provider Offline/Online End **/
    
    /** For Provider Decline New Booking Start **/
    public function providerDeclineBooking(Request $request)
    {
        $booking = ProviderDeclineBooking::where('booking_id',$request->booking_id)->where('provider_id',$request->provider_id)->first();
        if($booking == '')
        {
            $decline = new ProviderDeclineBooking;
            $decline->booking_id = $request->booking_id;
            $decline->provider_id = $request->provider_id;
            $decline->save();
            
            return response()->json(['status' => '200', 'message' => 'This Booking Successfully Decline and Again Search for other New Booking']);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'You are already decline this booking']);
        }
    }
    /** For Provider Decline New Booking End **/
    
    /** For Provider Serching Start**/
    public function newBooking(Request $request)
    {
        $providerid = $request->provider_id;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        
        
        
        $providerdata = Provider::where('id',$providerid)->first();
        if($providerdata->status=='1')
        {
            $decline = ProviderDeclineBooking::where('provider_id',$providerid)->select('booking_id')->get();
            $newBooking = Booking::join('users', 'bookings.user_id', '=', 'users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->whereNotIn('bookings.booking_id',$decline)->where('bookings.status','SEARCHING')->whereDate('bookings.created_at', Carbon::today())->select('bookings.*','users.profile_photo','users.first_name','users.last_name','users.email','users.country_code','users.mobile_number','services.id as serviceid','services.title as servicetitle','sub_services.id as subid','sub_services.title as subtitle','sub_services.price as subrate','sub_services.description as subdescription','sub_services.image as subimage','options')->inRandomOrder()->limit(1)->get();
            
            $arr = json_decode(json_encode($newBooking), TRUE);
            $items = array();
            for($i=0;count($arr)>$i;$i++)
            {
                $startTime = Carbon::parse($arr[$i]['schedule_start']);
                $endTime = Carbon::parse($arr[$i]['schedule_end']);
                $time = $startTime->diff($endTime)->format('%H');
                
                $items[$i]['id'] = $arr[$i]['id'];
                $items[$i]['booking_id'] = $arr[$i]['booking_id'];
                $items[$i]['user_pic'] = $arr[$i]['profile_photo'];
                $items[$i]['full_name'] = $arr[$i]['first_name']." ".$arr[$i]['last_name'];
                $items[$i]['email'] = $arr[$i]['email'];
                $items[$i]['mobile'] = $arr[$i]['country_code']."-".$arr[$i]['mobile_number'];
                $items[$i]['status'] = $arr[$i]['status'];
                $items[$i]['address'] = $arr[$i]['s_address'];
                $items[$i]['latitude'] = $arr[$i]['s_latitude'];
                $items[$i]['longitude'] = $arr[$i]['s_longitude'];
                
                $items[$i]['serviceid'] = $arr[$i]['serviceid'];
                $items[$i]['subid'] = $arr[$i]['subid'];
                $items[$i]['servicename'] = $arr[$i]['servicetitle'];
               $items[$i]['optionsss'] = $arr[$i]['options'];
               
                $items[$i]['service_name'] = $arr[$i]['subtitle'];
                $items[$i]['service_rate'] = $arr[$i]['subrate'];
                $items[$i]['service_description'] = $arr[$i]['subdescription'];
                $items[$i]['service_image'] = $arr[$i]['subimage'];
                $items[$i]['person'] = $arr[$i]['person'];
                $items[$i]['hours'] = $time;
                $items[$i]['total'] = $arr[$i]['subrate'] * $arr[$i]['person'];
                
                $items[$i]['price'] = $arr[$i]['amount'];
                $items[$i]['booking_date'] = date('d-m-Y', strtotime($arr[$i]['created_at']));
            }
        return response()->json(['status' => '200', 'message' => 'New Booking', 'data' => $items]);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'You are offline', 'data' => []]);   
        }
        
    }
    /** For Provider Serching End**/
    
    
    
         // for user bookingaccepted notification
 public function StatusAcceptedNotification($userid)
	    {
       $id = $userid;
$tokens = User::where('id',$id)->pluck('device_token')->all();


 $serverKey = 'AAAAJSC-HBE:APA91bGU3TNkTAEmAoa-3C6FBcIM5hdiaHSWLWvDO5gg_shY9auyxUSRP5Jn8qCR11rFnic8W2GTJAHwPWpJLtxVz-fTaK-vpuIJEd64Zi7Tdh9kEr8fDYpPsM2fuSPVFbahyDEkyJ7d';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => 'Wait for provider Call',
	            'title' => 'Your Booking Has Been Accepted',
	        );

	        $notifyData = [
                 "body" => 'Wait for provider Call',
	            'title' => 'Your Booking Has Been Accepted',
            ];

	        $registrationIds = $tokens;
	        
	      
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
         
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;


}
 // end for user bookingaccepted notification   
     
    
    
         // for user booking arrived notification
 public function StatusArrivedNotification($userid)
	    {
       $id = $userid;
$tokens = User::where('id',$id)->pluck('device_token')->all();


 $serverKey = 'AAAAJSC-HBE:APA91bGU3TNkTAEmAoa-3C6FBcIM5hdiaHSWLWvDO5gg_shY9auyxUSRP5Jn8qCR11rFnic8W2GTJAHwPWpJLtxVz-fTaK-vpuIJEd64Zi7Tdh9kEr8fDYpPsM2fuSPVFbahyDEkyJ7d';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => 'User has arrived at Client Location',
	            'title' => 'TowBooker',
	        );

	        $notifyData = [
                 "body" => 'User has arrived at Client Location',
	            'title' => 'TowBooker',
            ];

	        $registrationIds = $tokens;
	        
	      
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
         
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;


}
 // end for user booking arrived notification   
     
    
    
    
    
         // for user work strated notification
         
 public function StatusStratedNotification($userid)
	    {
       $id = $userid;
$tokens = User::where('id',$id)->pluck('device_token')->all();


 $serverKey = 'AAAAJSC-HBE:APA91bGU3TNkTAEmAoa-3C6FBcIM5hdiaHSWLWvDO5gg_shY9auyxUSRP5Jn8qCR11rFnic8W2GTJAHwPWpJLtxVz-fTaK-vpuIJEd64Zi7Tdh9kEr8fDYpPsM2fuSPVFbahyDEkyJ7d';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => 'Your has Started',
	            'title' => 'TowBooker',
	        );

	        $notifyData = [
                 "body" => 'Your has Started',
	            'title' => 'TowBooker',
            ];

	        $registrationIds = $tokens;
	        
	      
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
         
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;


}
 // end for user work started notification   
     
    
    
    
         // for user work completed notification
         
 public function StatusCompletedNotification($userid)
	    {
       $id = $userid;
$tokens = User::where('id',$id)->pluck('device_token')->all();


 $serverKey = 'AAAAJSC-HBE:APA91bGU3TNkTAEmAoa-3C6FBcIM5hdiaHSWLWvDO5gg_shY9auyxUSRP5Jn8qCR11rFnic8W2GTJAHwPWpJLtxVz-fTaK-vpuIJEd64Zi7Tdh9kEr8fDYpPsM2fuSPVFbahyDEkyJ7d';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => 'Your work has completed',
	            'title' => 'TowBooker',
	        );

	        $notifyData = [
                 "body" => 'Your work has completed',
	            'title' => 'TowBooker',
            ];

	        $registrationIds = $tokens;
	        
	      
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
         
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;


}
 // end for user work completed notification   
     
    
    
    // for user work completed notification
         
 public function StatusDroppeddNotification($userid)
	    {
       $id = $userid;
$tokens = User::where('id',$id)->pluck('device_token')->all();


 $serverKey = 'AAAAJSC-HBE:APA91bGU3TNkTAEmAoa-3C6FBcIM5hdiaHSWLWvDO5gg_shY9auyxUSRP5Jn8qCR11rFnic8W2GTJAHwPWpJLtxVz-fTaK-vpuIJEd64Zi7Tdh9kEr8fDYpPsM2fuSPVFbahyDEkyJ7d';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => 'Your service has been dropped',
	            'title' => 'TowBooker',
	        );

	        $notifyData = [
                 "body" => 'Your service has been dropped',
	            'title' => 'TowBooker',
            ];

	        $registrationIds = $tokens;
	        
	      
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
         
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;


}
 // end for user work completed notification   
     
    
    public function addproviderfund($providerid)
    {
        $id = $providerid;
         $user = Provider::where('id',$id)->first();
        $wallet = $user->wallet_balance + $request->amount;
        $user->wallet_balance = $wallet;
        $user->save();
        
        return response()->json(['status' => '200', 'message' => 'Fund Add Successfully', 'data' => $user]);
    }
    
    /** For Provider Booking Accept Start **/
    public function acceptBooking(Request $request)
    {
        $id = $request->id;
        $providerid = $request->provider_id;
        $providerData = Provider::where('id',$providerid)->first();
        
        $booking = Booking::findOrFail($id);
        $booking->provider_id = $providerid;
        $booking->provider_status = "ACCEPTED";
        $booking->status = "ACCEPTED";
        $booking->d_address = $providerData->business_address;
        $booking->d_latitude = $providerData->latitude;
        $booking->d_longitude = $providerData->longitude;
        $booking->track_latitude = $providerData->latitude;
        $booking->track_longitude = $providerData->longitude;
        
        

        $booking->save();
          
        $this->StatusAcceptedNotification($booking->user_id);
        
        return response()->json(['status' => '200', 'message' => "Booking Accept"]);
    }
    /** For Provider Booking Accept End **/
    
    /** For Provider Update Booking Status Start **/
    public function updateBookingStatus(Request $request)
    {
        $id = $request->booking_id;
        $status = $request->status;
        if($status == '1')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "ARRIVED";
            $booking->save(); 
            $this->StatusArrivedNotification($booking->user_id);
        }
        elseif($status == '2')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "STARTED";
            $booking->save();
            $this->StatusStratedNotification($booking->user_id);
        }
        elseif($status == '3')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "COMPLETED";
            
            $booking->save();
            
           
            
            $this->StatusCompletedNotification($booking->user_id);
        }
        elseif($status == '4')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "DROPPED";
            $booking->save();
            $this->StatusDroppeddNotification($booking->user_id);
        }
        return response()->json(['status' => '200', 'message' => 'Status has been updated']);
    }
    /** For Provider Update Booking Status End **/
    
    /** For Provider Update Track Lat Long Start**/
    public function updateTrack(Request $request)
    {
        $id = $request->booking_id;
        $lat = $request->track_lat;
        $long = $request->track_long;
        
        $track = Booking::where('booking_id',$id)->first();
        if($lat != '' && $long != '')
        {
            $track->track_latitude = $lat;
            $track->track_longitude = $long;
            $track->update();
        }
        
        return response()->json(['status' => '200', 'message' => 'Your Current Location', 'data'=>$track]);
    }
    /** For Provider Update Track Lat Long End**/
    
    /** For User Submit Review Start **/
    public function submitReview(Request $request)
    {
        $id = $request->booking_id;
        $rating = $request->provider_rating;
        $review = $request->provider_review;
       
        $booking = Booking::where('booking_id',$id)->first();
        $booking->provider_rated = $rating;
        $booking->provider_review = $review;
        $booking->update();
       
        return response()->json(['status' => '200', 'message' => 'Review Submitted Successfully']);
    }
    /** For User Submit Review End **/
    
    /** For Provider Get Booking History Start **/
    public function bookingHistory(Request $request)
    {
        $providerid = $request->provider_id;
        $booking = Booking::join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->join('users','bookings.user_id','=','users.id')->select('bookings.*','services.title as service_name','services.image as service_image','sub_services.title as sub_title','sub_services.price as amount','users.first_name as startname','sub_services.image as sub_image')->where('bookings.provider_id',$providerid)->orderBy('bookings.id','DESC')->get();
        
        $arr = json_decode(json_encode($booking), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++)
        {
            $items[$i]['id'] = $arr[$i]['id'];
             $items[$i]['single_name'] = $arr[$i]['startname'];
            $items[$i]['money'] = $arr[$i]['amount'];
            $items[$i]['booking_id'] = $arr[$i]['booking_id'];
            $items[$i]['sub_service'] = $arr[$i]['sub_title'];
            $items[$i]['datetime'] = $arr[$i]['schedule_date'];
            $items[$i]['status'] = $arr[$i]['provider_status'];
        }
        if($items != null)
        {
            return response()->json(['status' => '200', 'message' => 'User Booking History', 'data' => $items]);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'No Booking History Found']);
        }
    }
    /** For Provider Get Booking History End **/
    
    /** For Provider Wallet History Start **/
    public function walletHistory(Request $request)
    {
        $id = $request->id;
        $user = UserWalletHistory::where('user_type','1')->where('user_id',$id)->get();
        
        return response()->json(['status' => '200', 'message' => 'Wallet History', 'data' => $user]);
    }
    /** For Provider Wallet History End **/
    
    /** For Get Policy Start **/
    public function getPolicy()
    {
        $policy = Policy::all();
        return response()->json(['status' => '200', 'message' => 'Page Data', 'data' => $policy]);
    }
    /** For Get Policy End **/
    
    /*public function getDate()
    {
        $posts = Booking::whereDate('created_at', Carbon::today())->get();
        return response()->json(['data' => $posts]);
    }*/
    
    /** For Provider Review Start **/
    public function providerReview(Request $request)
    {
        $providerid = $request->userId;
        
        $review = Booking::join('users','bookings.user_id','=','users.id')->select('bookings.*','users.first_name as user_first','users.last_name as user_last')->where('provider_id',$providerid)->get();
        $arr = json_decode(json_encode($review), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++)
        {
            $items[$i]['id'] = $arr[$i]['id'];
                $items[$i]['full_name'] = $arr[$i]['user_first']." ".$arr[$i]['user_last'];
            $items[$i]['booking_id'] = $arr[$i]['booking_id'];
            $items[$i]['rating'] = $arr[$i]['provider_rated'];
            $items[$i]['review'] = $arr[$i]['provider_review'];
        }
        
        return response()->json(['status' => '200', 'message' => 'Provider Review', 'data' => $items]);
    }
    /** For Provider Review End **/
    
    
    public function withdrawamount(Request $request)
    {
        $user = Provider::where('id', $request->userid)->firstOrFail();
        if($user)
        {
            $oldwallet = $user->wallet;
            if($oldwallet >=  $request->withdraw_amount)
            {
                $provider = new Withdrawal;
                $provider->provider_id = $request->userid;
                $provider->amount = $request->withdraw_amount;
                $provider->save();
                
                $user->wallet = $oldwallet - $request->withdraw_amount;
                $user->save();
                
                return response()->json(['status' => '200', 'message' => 'Amount withdraw successfully']);
                
            }
            else
            {
                return response()->json(['status' => '210', 'message' => 'you have insufficient fund']);
            }
            
        }
        else
        {
         return response()->json(['status' => '210', 'message' => 'User not found']);
        }
    }
}
