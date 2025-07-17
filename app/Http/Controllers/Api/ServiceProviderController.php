<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\Otp;
use App\Models\Country;
use App\Models\Booking;
use App\Models\Policy;
use App\Models\Message;
use App\Models\Withdrawal;
use App\Models\AppSetting;
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
use Illuminate\Auth\Notifications\ResetPassword;
//use Kreait\Firebase\Auth;
//use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
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
            'birth_date' => 'required',
            'postcode' => 'required',
            'password' => 'required|string|min:8',
            'sia_license' => 'required',
            //'code' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $provider = Provider::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'postcode' => $request->postcode,
            'mobile_number' => rand(1000000000,9999999999),
            'birth_date' => $request->birth_date,
            'postcode' => $request->postcode,
            'sia_license' => $request->sia_license,
            'password' => Hash::make($request->password),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'country_code' => '+1'
            //'business_name' => $request->business_name,
            //'incorporation_no' => $request->incorporation_no,
            //'business_address' => $request->business_address,
            //'latitude' => $request->latitude,
            //'longitude' => $request->longitude,
            //'business_type' => $request->business_type,
            //'service_type' => $request->service_type,
            //'device_token' => $request->device_token,
        ]);
        
        if($request->email != '')
        {
        $to = $request->email;
        $subject = "Welcome to Book In Mechanic";
                    
        $message = "
        <!DOCTYPE html>
        <html lang='en' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:v='urn:schemas-microsoft-com:vml'>
        <head>
        <title>Book In Mechanic</title>
        <meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
        <meta content='width=device-width, initial-scale=1.0' name='viewport'/>
        <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'/>
        <style>
		*
		{
			box-sizing: border-box;
		}

		body
		{
			margin: 0;
			padding: 0;
		}

		a[x-apple-data-detectors]
		{
			color: inherit !important;
			text-decoration: inherit !important;
		}

		#MessageViewBody a
		{
			color: inherit;
			text-decoration: none;
		}

		p
		{
			line-height: inherit
		}

		@media (max-width:670px)
		{
			.icons-inner
			{
				text-align: center;
			}

			.icons-inner td
			{
				margin: 0 auto;
			}

			.row-content
			{
				width: 100% !important;
			}

			.column .border
			{
				display: none;
			}

			.stack .column
			{
				width: 100%;
				display: block;
			}
		}
	    </style>
    </head>
    <body style='background-color: #F5F5F5; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;'>
        <table border='0' cellpadding='0' cellspacing='0' class='nl-container' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #F5F5F5;' width='100%'>
            <tbody>
                <tr>
                    <td>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row row-1' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row-content stack' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;' width='650'>
                                            <tbody>
                                                <tr>
                                                    <td class='column column-1' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;' width='100%'>
                                                        <div class='spacer_block' style='height:30px;line-height:30px;font-size:1px;'></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row row-2' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row-content' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; color: #333; width: 650px;' width='650'>
                                            <tbody>
                                                <tr>
                                                    <td class='column column-1' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-left: 25px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;' width='50%'>
                                                        <table border='0' cellpadding='0' cellspacing='0' class='image_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                                                            <tr>
                                                                <td style='width:100%;padding-right:0px;padding-left:0px;padding-top:25px;padding-bottom:25px;'>
                                                                    <div style='line-height:10px'><img alt='Image' src='https://grabahamas.com/public/email/mechanic.png' style='display: block; height: auto; border: 0; width: 135px; max-width: 100%;' title='Image' width='135'/></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row row-3' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row-content stack' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #D6E7F0; color: #000000; width: 650px;' width='650'>
                                            <tbody>
                                                <tr>
                                                    <td class='column column-1' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-left: 25px; padding-right: 25px; padding-top: 5px; padding-bottom: 60px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;' width='100%'>
                                                        <table border='0' cellpadding='0' cellspacing='0' class='image_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                                                            <tr>
                                                                <td style='padding-top:45px;width:100%;padding-right:0px;padding-left:0px;'>
                                                                    <div align='center' style='line-height:10px'><img alt='Image' src='https://grabahamas.com/public/email/welcome.png' style='display: block; height: auto; border: 0; width: 540px; max-width: 100%;' title='Image' width='540'/></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border='0' cellpadding='0' cellspacing='0' class='text_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;' width='100%'>
                                                            <tr>
                                                                <td style='padding-left:15px;padding-right:10px;padding-top:20px;'>
                                                                    <div style='font-family: sans-serif'>
                                                                        <div style='font-size: 12px; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 18px; color: #052d3d; line-height: 1.5;'>
                                                                            <p style='margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 75px;'><span style='font-size:50px;'><strong><span style='font-size:50px;'><span style='font-size:38px;'>WELCOME</span></span></strong></span></p>
                                                                            <p style='margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 51px;'><span style='font-size:34px;'><strong><span style='font-size:34px;'><span style='color:#2190e3;font-size:34px;'>".$request->first_name." ".$request->last_name."</span></span></strong></span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border='0' cellpadding='10' cellspacing='0' class='text_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;' width='100%'>
                                                            <tr>
                                                                <td>
                                                                    <div style='font-family: sans-serif'>
                                                                        <div style='font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #555555; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;'>
                                                                            <p style='margin: 0; font-size: 14px; text-align: center;'><span style='font-size:18px;color:#000000;'>Thanks for signing up for our updates. We'll be sending an occasional email with everything new and good that you'll probably want to know about: new products, posts, promos, and parties.</span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row row-4' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <table align='center' border='0' cellpadding='0' cellspacing='0' class='row-content stack' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 650px;' width='650'>
                                            <tbody>
                                                <tr>
                                                    <td class='column column-1' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 20px; padding-bottom: 60px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;' width='100%'>
                                                        <table border='0' cellpadding='10' cellspacing='0' class='social_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                                                            <tr>
                                                                <td>
                                                                    <table align='center' border='0' cellpadding='0' cellspacing='0' class='social-table' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='188px'>
                                                                        <tr>
                                                                            <td style='padding:0 15px 0 0px;'><a href='https://www.facebook.com/' target='_blank'><img alt='Facebook' src='https://grabahamas.com/public/email/facebook.png' height='32' style='display: block; height: auto; border: 0;' title='Facebook' width='32'/></a></td>
                                                                            <td style='padding:0 15px 0 0px;'><a href='https://twitter.com/' target='_blank'><img alt='Twitter' height='32' src='https://grabahamas.com/public/email/twitter2x.png' style='display: block; height: auto; border: 0;' title='Twitter' width='32'/></a></td>
                                                                            <td style='padding:0 15px 0 0px;'><a href='https://instagram.com/' target='_blank'><img alt='Instagram' height='32' src='https://grabahamas.com/public/email/instagram2x.png' style='display: block; height: auto; border: 0;' title='Instagram' width='32'/></a></td>
                                                                            <td style='padding:0 15px 0 0px;'><a href='https://www.pinterest.com/' target='_blank'><img alt='Pinterest' height='32' src='https://grabahamas.com/public/email/pinterest2x.png' style='display: block; height: auto; border: 0;' title='Pinterest' width='32'/></a></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border='0' cellpadding='10' cellspacing='0' class='text_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;' width='100%'>
                                                            <tr>
                                                                <td>
                                                                    <div style='font-family: sans-serif'>
                                                                        <div style='font-size: 12px; mso-line-height-alt: 18px; color: #555555; line-height: 1.5; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;'>
                                                                            <p style='margin: 0; font-size: 14px; text-align: center;'>BookInMechanic - Lorem ipsum dolor sit amet hasellus sagittis aliquam luctus.</p>
                                                                            <p style='margin: 0; font-size: 14px; text-align: center;'>329 California St, San Francisco, CA 94118</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border='0' cellpadding='10' cellspacing='0' class='divider_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='100%'>
                                                            <tr>
                                                                <td>
                                                                    <div align='center'>
                                                                        <table border='0' cellpadding='0' cellspacing='0' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt;' width='60%'>
                                                                            <tr>
                                                                                <td class='divider_inner' style='font-size: 1px; line-height: 1px; border-top: 1px dotted #C4C4C4;'><span></span></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table border='0' cellpadding='10' cellspacing='0' class='text_block' role='presentation' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;' width='100%'>
                                                            <tr>
                                                                <td>
                                                                    <div style='font-family: sans-serif'>
                                                                        <div style='font-size: 12px; mso-line-height-alt: 14.399999999999999px; color: #4F4F4F; line-height: 1.2; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif;'>
                                                                            <p style='margin: 0; font-size: 12px; text-align: center;'><span style='font-size:14px;'><a href='https://appok.in' rel='noopener' style='text-decoration: none; color: #2190E3;' target='_blank'><strong>Help& FAQ's</strong></a> |<span style='background-color:transparent;font-size:14px;'>+91-91118-03533</span></span></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
        ";
                
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
        // More headers
        $headers .= 'From: <mechanic@grabahamas.com>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";
                    
        //mail($to,$subject,$message,$headers);
        }
        
        $token = $provider->createToken('auth_token')->plainTextToken;
        //$token = $user->createToken('API Token')->accessToken;

        return response()->json(['status' => '200', 'message' => 'Provider Register Successfully', 'data' => $provider,'access_token' => $token, 'token_type' => 'Bearer','id' => $provider->id ]);   
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

        return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', 'id' => $user->id ]);
    }
    /** For Email Login End **/

    /* Google Login */
    public function googleLogin(Request $request)
    {
        request()->validate([
            'token' => 'required',
        ]
        );
        $idTokenString = request('token');
        if (!$idTokenString) {
            return response()->json(['error' => 'ID Token required'], 400);
        }
        try{
            $auth = app('firebase.auth');
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');
            
            $firebaseUser = $auth->getUser($uid);

            $fullName = $firebaseUser->displayName;
            $name = explode(' ', $fullName, 2);
            $first_name = $name[0];
            $last_name = $name[1];
            // Check if the user exists in our database
            $provider = Provider::firstOrCreate(
                ['email' => $firebaseUser->email],
                [
                    'first_name' => $first_name ?? 'User',
                    'last_name' => $last_name,
                    'password' => Hash::make(uniqid()),
                    'country_code' => '91',
                    //'firebase_uid' => $uid,
                    //'mobile' => rand(1000000000,9999999999)
                ]
            );
            
            // // Generate Laravel API Token
             $token = $provider->createToken('API Token')->accessToken;

            //return response()->json(['user' => $firebaseUser]);
            return response()->json(['status' => '200', 'message' => 'Login with google successfully.', 'token' => $token, 'provider' => $provider]);

        }
        catch (\Exception $e)
        {
            return response()->json(['error' => 'Invalid Token'], 401);
        }
    
    }
    /** For Forgot Password Start **/
    public function forgotPassword(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email|exists:providers,email"
        ]);
        if ($validator->fails())
        {
            return response(['status' => '422', 'message'=>$validator->errors()->all()]);
        }
        

        $user = Provider::where('email', $request->email)->first();
        
        $token = Password::createToken($user);
        // Construct the reset URL manually
    $resetUrl = url(config('app.url') . route('password.reset', ['token' => $token], false));

    // Generate the reset email content using MailMessage
    $mailMessage = (new ResetPassword($token))->toMail($user);
        /*$response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT)
        {
            $message = "Mail send successfully";
        }else
        {
            $message = "Email could not be sent to this email address";
        }*/
        //$to = "samita@kusmail.com";  // Change to your desired recipient
        $to = $request->email;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
        // More headers
        $headers .= 'From: "TowPartner" <mechanic@grabahamas.com>' . "\r\n";
        // $headers .= 'Cc: myboss@example.com' . "\r\n";

        $subject = $mailMessage->subject. ' for Provider';
        $line = $mailMessage->introLines[0]; // First line of the email
        $actionText = $mailMessage->actionText; // Button text
        //$actionUrl = $mailMessage->actionUrl;  // Reset password URL
        $actionUrl = url(route('provider.password.reset', [
			'token' => $token,
			'email' => $user->email,
		], false));
        $mail_message = '<div style="background-color:#e0e0d1"><div style="font-size:20px;font-weight:bold;text-align: center;padding-top:10px;margin-bottom:55px">TowPartner</div>';
        $mail_message .= '<div style="margin-left:350px;background-color:#fff;padding-left:20px;padding-top:20px;width:500px"><span style="font-size:20px;font-weight:bold;">Hello!</span>';
        $mail_message .= '<p>'.$line.'</p>';
        $mail_message .= '<a href="'.$actionUrl.'">'.$actionText.'</a>';
        $mail_message .= '<p>'.$mailMessage->outroLines[0].'</p>';
        $mail_message .= '<p>'.$mailMessage->outroLines[1].'</p>';
        $mail_message .= '<p>Regards,</p>';
        $mail_message .= '<p>TowPartner</p>';
        $mail_message .= '</div>';
        $mail_message .= '</div>';
        if (mail($to, $subject, $mail_message, $headers)) {
            $message = "Mail send successfully";
        } else {
            $message = "Email sending failed.";
        }
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
            $user->save();
            
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', 'id' => $user->id]);
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
            $newBooking = Booking::join('users', 'bookings.user_id', '=', 'users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->whereNotIn('bookings.booking_id',$decline)->where('bookings.status','SEARCHING')->whereDate('bookings.created_at', Carbon::today())->select('bookings.*','users.profile_photo','users.first_name','users.last_name','users.email','users.country_code','users.mobile_number','services.id as serviceid','sub_services.id as subid','sub_services.title as subtitle','sub_services.price as subrate','sub_services.description as subdescription','sub_services.image as subimage')->inRandomOrder()->limit(1)->get();
            
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
            $booking->status = "ARRIVED";
            $booking->schedule_start = now();
            $booking->save(); 
        }
        elseif($status == '2')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "STARTED";
            $booking->status = "STARTED";
            $booking->save();
        }
        elseif($status == '3')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "COMPLETED";
            $booking->save();
        }
        elseif($status == '4')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->provider_status = "DROPPED";
            $booking->save();
        }
        
        return response()->json(['status' => '200', 'message' => $booking->provider_status]);
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
        $booking->save();
       
        return response()->json(['status' => '200', 'message' => 'Review Submitted Successfully']);
    }
    /** For User Submit Review End **/
    
    /** For Provider Get Booking History Start **/
    public function bookingHistory(Request $request)
    {
        $provider = auth()->user();
        $providerid = $provider->id;
        //$booking = Booking::join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->select('bookings.*','services.title as service_name','services.image as service_image','sub_services.title as sub_title','sub_services.image as sub_image')->where('bookings.provider_id',$providerid)->orderBy('bookings.id','DESC')->get();
        
        $booking = Booking::join('services','bookings.service_id','=','services.id')
        ->join('sub_services','bookings.sub_service_id','=','sub_services.id')
        ->leftJoin('providers', 'bookings.provider_id', '=', 'providers.id')
        ->select(
                        'bookings.*',
                        'services.title as service_name',
                        'services.image as service_image',
                        'sub_services.title as sub_title',
                        'sub_services.image as sub_image',
                        'providers.first_name as provider_first_name',
                        'providers.last_name as provider_last_name',
                        'providers.profile_picture as provider_image',
                        'providers.rating as provider_rating',
                        'providers.business_name',
                        'providers.business_address'
                    )
        ->where('bookings.provider_id',$providerid)->orderBy('bookings.id','DESC')->get();
        $arr = json_decode(json_encode($booking), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++){
            $firstName = $arr[$i]['provider_first_name'] ?? '';
            $lastName = $arr[$i]['provider_last_name'] ?? '';

            if ($firstName || $lastName) {
                $items[$i]['fullname'] = trim("$firstName $lastName");
            } else {
                $items[$i]['fullname'] = '';
            }

            $items[$i]['id'] = $arr[$i]['id'];
            $items[$i]['booking_id'] = $arr[$i]['booking_id'];
            $items[$i]['sub_service'] = $arr[$i]['sub_title'];
            $items[$i]['datetime'] = $arr[$i]['schedule_date'];
            $items[$i]['provider_rating'] = $arr[$i]['provider_rated'];
            $items[$i]['money'] = $arr[$i]['amount'];
            $items[$i]['status'] = $arr[$i]['provider_status'];
        }
        if($items != null)
        {
            return response()->json(['status' => '200', 'message' => 'User Booking History', 'data' => $items]);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'No Booking History Found', 'id' => $providerid]);
        }
    }
    /** For Provider Get Booking History End **/
    
    /** For Provider Get Booking in Details Start **/
    public function bookingDetail(Request $request)
    {
        $bookingid = $request->booking_id;
        
        $booking = Booking::join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->join('dress_codes','bookings.dress_code','=','dress_codes.id')->select('bookings.*','services.title as service_name','services.image as service_image','sub_services.title as sub_title','sub_services.image as sub_image','dress_codes.title as dress_title','dress_codes.image as dress_image')->where('bookings.booking_id',$bookingid)->get();
        
        $arr = json_decode(json_encode($booking), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++)
        {
            $items[$i]['id'] = $arr[$i]['id'];
            $items[$i]['booking_id'] = $arr[$i]['booking_id'];
            $items[$i]['sub_service'] = $arr[$i]['sub_title'];
            $items[$i]['datetime'] = $arr[$i]['schedule_date']." ".$arr[$i]['schedule_start']." ".$arr[$i]['schedule_end'];
            $items[$i]['status'] = $arr[$i]['status'];
            $items[$i]['total'] = $arr[$i]['amount'] * $arr[$i]['person'];
            $items[$i]['user_address'] = $arr[$i]['s_address'];
            $items[$i]['dress_image'] = $arr[$i]['dress_image'];
            $items[$i]['dress_title'] = $arr[$i]['dress_title'];
        }
        
        return response()->json(['status' => '200', 'message' => 'Provider Booking in Detail', 'data' => $items]);
        
    } 
    /** For Provider Get Booking in Details End **/
    
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
        $providerid = $request->id;
        $review = Booking::join('users','users.id','=','bookings.user_id')->where('bookings.provider_id',$providerid)->where('bookings.status','COMPLETED')
        ->orderBy('bookings.id', 'desc')
        ->select('bookings.*','users.first_name','users.last_name')->get();
        $arr = json_decode(json_encode($review), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++)
        {
            $items[$i]['id'] = $arr[$i]['id'];
            $items[$i]['user_name'] = $arr[$i]['first_name']." ".$arr[$i]['last_name'];
            $items[$i]['booking_id'] = $arr[$i]['booking_id'];
            $items[$i]['rating'] = $arr[$i]['user_rated'];
            $items[$i]['review'] = $arr[$i]['user_review'];
            $items[$i]['review_date'] = date('d-m-Y', strtotime($arr[$i]['updated_at']));
            $items[$i]['review_time'] = date('H:i', strtotime($arr[$i]['updated_at']));
        }
        
        return response()->json(['status' => '200', 'message' => 'Provider Review', 'data' => $items]);
    }
    /** For Provider Review End **/
    
    public function withdrawAmount(Request $request)
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
    
    public function appSetting()
    {
        $app = AppSetting::where('id','1')->first();
        
        return response()->json(['status' => '200', 'message' => 'Get Currency Code', 'data' => $app->currency_code]);
    }
    /*
    * Provider place bid
    *
    */
    public function providerBid(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'provider_id' => 'required|integer',
            'price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if the booking exists
            $booking = Booking::where('booking_id', $request->booking_id)->first();
            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Check if the provider exists
            $provider = Provider::find($request->provider_id);
            if (!$provider) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Provider not found'
                ], 404);
            }

            // Update the booking_provider_search record
            $updated = DB::table('booking_provider_search')
                ->where('booking_id', $request->booking_id)
                ->where('provider_id', $request->provider_id)
                ->update([
                    'price' => $request->price,
                    'bid_placed' => 1,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Bid updated successfully',
                    'data' => [
                        'booking_id' => $request->booking_id,
                        'provider_id' => $request->provider_id,
                        'price' => $request->price
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => '404',
                    'message' => 'No matching record found in booking_provider_search'
                ], 404);
            }

        } catch (\Exception $e) {
            \Log::error('Error in provider bid: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyBookingOtp(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'booking_otp' => 'required|string|size:4',
            'before_work_proof' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if the booking exists and verify OTP
            $booking = Booking::where('booking_id', $request->booking_id)
                            ->where('booking_otp', $request->booking_otp)
                            ->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Invalid booking ID or OTP'
                ], 404);
            }

            // Handle base64 image conversion for before_work_proof
            if($request->before_work_proof != '') {
                $image = $request->before_work_proof;  // base64 encoded image
                
                if (preg_match('/^data:image\/(\w+);base64,/', $image, $typeMatch)) {
                    $imageType = strtolower($typeMatch[1]); // e.g. "jpeg", "png", "webp"

                    // Validate allowed types
                    if (!in_array($imageType, ['jpeg', 'jpg', 'png', 'webp'])) {
                        return response()->json(['error' => 'Unsupported image type'], 400);
                    }

                    // Remove base64 prefix
                    $imageBase64 = substr($image, strpos($image, ',') + 1);

                    // Decode base64 safely
                    $decodedImage = base64_decode($imageBase64);

                    // Check if decoding succeeded
                    if ($decodedImage === false) {
                        return response()->json(['error' => 'Image decoding failed'], 400);
                    }

                    // Generate unique file name
                    $imageName = time() . '.' . $imageType;

                    // Save file
                    $filePath = public_path('images/' . $imageName);
                    file_put_contents($filePath, $decodedImage);

                    // Save image URL
                    $booking->before_work_proof = url('public/images/' . $imageName);
                }
            }

            $booking->status = 'STARTED';
            $booking->save();

            return response()->json([
                'status' => '200',
                'message' => 'OTP verified and before work proof updated successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'before_work_proof' => $booking->before_work_proof,
                    'status' => $booking->status
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in verify booking OTP: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadAfterProblem(Request $request) {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string',
                'after_work_proof' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the booking
            $booking = Booking::where('booking_id', $request->booking_id)->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Update the booking with after work proof
            if($request->after_work_proof != '')
            {
                $image = $request->after_work_proof;  // your base64 encoded
                
                if (preg_match('/^data:image\/(\w+);base64,/', $image, $typeMatch)) {
                    $imageType = strtolower($typeMatch[1]); // e.g. "jpeg", "png", "webp"

                    // Validate allowed types
                    if (!in_array($imageType, ['jpeg', 'jpg', 'png', 'webp'])) {
                        return response()->json(['error' => 'Unsupported image type'], 400);
                    }

                    // Remove base64 prefix
                    $imageBase64 = substr($image, strpos($image, ',') + 1);

                    // Decode base64 safely
                    $decodedImage = base64_decode($imageBase64);

                    // Check if decoding succeeded
                    if ($decodedImage === false) {
                        return response()->json(['error' => 'Image decoding failed'], 400);
                    }

                    // Generate unique file name
                    $imageName = time() . '.' . $imageType;

                    // Save file
                    $filePath = public_path('images/' . $imageName);
                    file_put_contents($filePath, $decodedImage);

                    // Save image URL
                    $booking->after_work_proof = url('public/images/' . $imageName);
                }
            }
            $booking->save();

            return response()->json([
                'status' => '200',
                'message' => 'After work proof uploaded successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'after_work_proof' => $imageName,
                    'status' => $booking->status
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in uploadAfterProblem: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadSignature(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string|exists:bookings,booking_id',
                'signature' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $appSettings = AppSetting::where('id', '1')->first();
            
            // Get booking details
            $booking = Booking::where('booking_id', $request->booking_id)->first();
            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Handle signature upload
            if (preg_match('/^data:image\/(\w+);base64,/', $request->signature, $typeMatch)) {
                $imageType = strtolower($typeMatch[1]); // e.g. "jpeg", "png", "webp"

                // Validate allowed types
                if (!in_array($imageType, ['jpeg', 'jpg', 'png', 'webp'])) {
                    return response()->json(['error' => 'Unsupported image type'], 400);
                }

                // Remove base64 prefix
                $imageBase64 = substr($request->signature, strpos($request->signature, ',') + 1);

                // Decode base64 safely
                $decodedImage = base64_decode($imageBase64);

                // Check if decoding succeeded
                if ($decodedImage === false) {
                    return response()->json(['error' => 'Image decoding failed'], 400);
                }

                // Generate unique file name
                $imageName = time() . '.' . $imageType;
                $filePath = public_path('images/' . $imageName);
                
                // Save file
                file_put_contents($filePath, $decodedImage);

                // Update booking with signature
                $booking->signature = url('images/' . $imageName);
                
            }
            $booking->status = 'COMPLETED';
            //$booking->provider_status = 'COMPLETED';
            $booking->schedule_end = now();
            $booking->save();
            // Fetch data from booking_provider_search
            $providerSearch = DB::table('booking_provider_search')
                ->where('booking_id', $request->booking_id)
                ->where('provider_id', $booking->provider_id)
                ->first();

            if (!$providerSearch) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Provider search record not found'
                ], 404);
            }
            $scheduleStart = Carbon::parse($booking->schedule_start);
            $scheduleEnd = Carbon::parse($booking->schedule_end);

            // Calculate difference in hours (with decimal if needed)

            $hours = $scheduleStart->diffInMinutes($scheduleEnd) / 60;
            $time_price = $hours * $appSettings->time_price;
            $base_price = $providerSearch->price - $time_price - $providerSearch->distance_price;
            DB::table('booking_provider_search')
                ->where('booking_id', $request->booking_id)
                ->where('provider_id', $booking->provider_id)
                ->update(['time_price' => $time_price, 'base_price' => $base_price]);

            return response()->json([
                'status' => '200',
                'message' => 'Signature uploaded and wallet balances updated successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'signature_url' => $booking->signature,
                    'hours' => $hours,
                    'time_price' => $time_price,
                    'base_price' => $base_price
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in uploadSignature: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function providerFeedback(Request $request) {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string',
                'provider_rated' => 'required|numeric|min:1|max:5',
                'provider_review' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the booking
            $booking = Booking::where('booking_id', $request->booking_id)->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Update the booking with provider feedback
            $booking->provider_rated = $request->provider_rated;
            $booking->provider_review = $request->provider_review;
            $booking->save();

            // Calculate average rating for the provider
            $averageRating = Booking::where('provider_id', $booking->provider_id)
                ->whereNotNull('provider_rated')
                ->avg('provider_rated');

            // Update provider's rating
            $provider = Provider::where('id', $booking->provider_id)->first();
            if ($provider) {
                $provider->rating = round($averageRating, 1);
                $provider->save();
            }

            return response()->json([
                'status' => '200',
                'message' => 'Feedback submitted successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'provider_rated' => $booking->provider_rated,
                    'provider_review' => $booking->provider_review,
                    'provider_average_rating' => round($averageRating, 1)
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in providerFeedback: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserBooking(Request $request)
    {
        try {
            $provider_id = $request->provider_id;
            $latitude = $request->lat;
            $longitude = $request->long;
            
            if (!$provider_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Provider ID is required'
                ], 400);
            }

            // Get single booking provider search record with user details
            $bookingProviderSearch = DB::table('booking_provider_search')
                ->join('users', 'booking_provider_search.user_id', '=', 'users.id')
                ->join('bookings', 'booking_provider_search.booking_id', '=', 'bookings.booking_id')
                ->select('booking_provider_search.*', 'users.first_name', 'users.last_name', 'users.email', 'users.profile_photo')
                ->where('booking_provider_search.provider_id', $provider_id)
                 ->where('booking_provider_search.skip_job', '=', 0)
                ->where('bookings.status', '=', 'SEARCHING')
                ->orderBy('booking_provider_search.id', 'DESC')
                ->first();

            if (!$bookingProviderSearch) {
                return response()->json([
                    'status' => '404',
                    'message' => 'No booking found'
                ], 404);
            }

            // Get booking data
            $booking = DB::table('bookings')
                ->where('booking_id', $bookingProviderSearch->booking_id)
                ->where('status', '=', 'SEARCHING')
                ->first();

            if ($booking) {
                // Process options with questions
                $options_with_questions = null;
                if (!empty($booking->options)) {
                    $rawQuestion = $booking->options;
                    $fixedQuestion = preg_replace("/'([^']+)'/", '"$1"', $rawQuestion);
                    $options = json_decode($fixedQuestion, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $err = 'Failed to decode options JSON: ' . json_last_error_msg();
                    } elseif (is_array($options)) {
                        if (isset($options[0]['question_id'])) {
                            $options_with_questions = array_map(function($opt) {
                                if (isset($opt['question_id'])) {
                                    $question = \DB::table('condition_questions')->where('id', $opt['question_id'])->value('question');
                                    $opt['question'] = $question;
                                }
                                return $opt;
                            }, $options);
                        } elseif (isset($options['question_id'])) {
                            $question = \DB::table('condition_questions')->where('id', $options['question_id'])->value('question');
                            $options['question'] = $question;
                            $options_with_questions = $options;
                        } else {
                            $options_with_questions = $options;
                        }
                    }
                }
                $booking->options = $options_with_questions;
            }

            // Get service data
            $service = DB::table('services')
                ->select('id', 'title', 'image', 'description')
                ->where('id', $booking->service_id)
                ->first();

            // Get sub service data
            $subService = DB::table('sub_services')
                ->select('id', 'service_id', 'title', 'image', 'description')
                ->where('id', $booking->sub_service_id)
                ->first();

            return response()->json([
                'status' => '200',
                'message' => 'Get User Booking Details',
                'data' => [
                    'booking_provider_search' => $bookingProviderSearch,
                    'bookings' => $booking,
                    'services' => $service,
                    'sub_services' => $subService
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /*
    * Skip jobs by provider
    */
    public function skipJobs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_id' => 'required|exists:providers,id',
            'booking_id' => 'required|exists:bookings,booking_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            DB::table('booking_provider_search')
                ->where('provider_id', $request->provider_id)
                ->where('booking_id', $request->booking_id)
                ->update([
                    'skip_job' => 1,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => '200',
                'message' => 'Job skipped by the provider'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '500',
                'message' => 'Failed to skip job',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get job summary details
     */
    public function getJobSummary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bid' => 'required|exists:booking_provider_search,booking_id',
            'pid' => 'required|exists:booking_provider_search,provider_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $jobSummary = DB::table('booking_provider_search')
                ->join('bookings', 'booking_provider_search.booking_id', '=', 'bookings.booking_id')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->join('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                ->join('providers', 'booking_provider_search.provider_id', '=', 'providers.id')
                ->where('booking_provider_search.booking_id', $request->bid)
                ->where('booking_provider_search.provider_id', $request->pid)
                ->select(
                    'booking_provider_search.id',
                    'booking_provider_search.booking_id',
                    'booking_provider_search.provider_id',
                    'booking_provider_search.user_id',
                    'booking_provider_search.price',
                    'booking_provider_search.distance',
                    'booking_provider_search.skip_job',
                    'bookings.id',
                    'bookings.booking_id',
                    'bookings.service_id',
                    'bookings.sub_service_id',
                    'bookings.status',
                    'bookings.booking_type',
                    'bookings.amount',
                    'bookings.payment_mode',
                    'bookings.schedule_start',
                    'bookings.schedule_end',
                    'bookings.vehicle_description',
                    'bookings.s_latitude',
                    'bookings.s_longitude',
                    'bookings.vehicle_image',
                    'bookings.paid',
                    'providers.latitude as provider_latitude',
                    'providers.longitude as provider_longitude',
                    'services.title as service_title',
                    'services.image as service_image',
                    'services.description as service_description',
                    'sub_services.title as sub_service_title',
                    'sub_services.image as sub_service_image',
                    'sub_services.description as sub_service_description',
                    'sub_services.price as sub_service_price',
                    'providers.latitude as provider_latitude',
                    'providers.longitude as provider_longitude',
                    'booking_provider_search.price as total_price',
                    'booking_provider_search.distance as provider_distance',
                    DB::raw('COALESCE(booking_provider_search.base_price, 0) as base_price'),
                    DB::raw('COALESCE(booking_provider_search.time_price, 0) as time_price'),
                    DB::raw('COALESCE(booking_provider_search.distance_price, 0) as distance_price'),
                    DB::raw('ROUND(TIMESTAMPDIFF(MINUTE, bookings.schedule_start, bookings.schedule_end) / 60, 2) as duration_hours')
                )
                ->get();

            if ($jobSummary->isEmpty()) {
                return response()->json([
                    'status' => '404',
                    'message' => 'No job summary found for this booking'
                ], 404);
            }

            return response()->json([
                'status' => '200',
                'message' => 'Job summary retrieved successfully',
                'data' => $jobSummary
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => '500',
                'message' => 'Failed to retrieve job summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /*
    * Update business details for the provider_id
    */
    public function updateProvider(Request $request)
    {
        try {
            // Get authenticated provider from token
            $provider = auth()->user();
            
            if (!$provider) {
                return response()->json([
                    'status' => '401',
                    'message' => 'Unauthorized - Invalid or missing token'
                ], 401);
            }

            // Update provider details only if fields are provided
            if ($request->has('business_name')) {
                $provider->business_name = $request->business_name;
            }
            if ($request->has('incorporation_no')) {
                $provider->incorporation_no = $request->incorporation_no;
            }
            if ($request->has('business_address')) {
                $provider->business_address = $request->business_address;
            }
            if ($request->has('business_type')) {
                $provider->business_type = $request->business_type;
            }
            if ($request->has('service_type')) {
                $provider->service_type = $request->service_type;
            }
            if ($request->has('first_name')) {
                $provider->first_name = $request->first_name;
            }
            if ($request->has('last_name')) {
                $provider->last_name = $request->last_name;
            }
            if ($request->has('mobile_number')) {
                $provider->mobile_number = $request->mobile_number;
            }
            if ($request->has('email')) {
                $provider->email = $request->email;
            }
            if($request->profile_picture != '' || $request->profile_picture)
            {
                $image = $request->profile_picture;  // your base64 encoded
                
                if (preg_match('/^data:image\/(\w+);base64,/', $image, $typeMatch)) {
                    $imageType = strtolower($typeMatch[1]); // e.g. "jpeg", "png", "webp"

                    // Validate allowed types
                    if (!in_array($imageType, ['jpeg', 'jpg', 'png', 'webp'])) {
                        return response()->json(['error' => 'Unsupported image type'], 400);
                    }

                    // Remove base64 prefix
                    $imageBase64 = substr($image, strpos($image, ',') + 1);

                    // Decode base64 safely
                    $decodedImage = base64_decode($imageBase64);

                    // Check if decoding succeeded
                    if ($decodedImage === false) {
                        return response()->json(['error' => 'Image decoding failed'], 400);
                    }

                    // Generate unique file name
                    $imageName = time() . '.' . $imageType;
    
                    // Save file
                    
                    $filePath = public_path('images/' . $imageName);
                    file_put_contents($filePath, $decodedImage);

                    // Save image URL
                    $provider->profile_picture = url('public/images/' . $imageName);
                }
            }
            $provider->save();

            return response()->json([
                'status' => '200',
                'message' => 'Provider details updated successfully',
                'data' => $provider
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in updateProvider: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user details for a specific booking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetails(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string|exists:bookings,booking_id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get user details through the booking
            $userDetails = DB::table('bookings')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->where('bookings.booking_id', $request->booking_id)
                ->select(
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.email',
                    'users.mobile_number',
                    'users.country_code',
                    'users.profile_photo',
                    'users.birth_date',
                    'users.postcode',
                    'users.wallet_balance',
                    'users.status',
                    'bookings.s_address as user_address',
                    'bookings.s_latitude as user_latitude',
                    'bookings.s_longitude as user_longitude'
                )
                ->first();

            if (!$userDetails) {
                return response()->json([
                    'status' => '404',
                    'message' => 'User details not found for this booking'
                ], 404);
            }

            return response()->json([
                'status' => '200',
                'message' => 'User details retrieved successfully',
                'data' => $userDetails
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getUserDetails: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserBookings(Request $request)
    {
        try {
            $provider_id = $request->provider_id;
            $latitude = $request->lat;
            $longitude = $request->long;
            
            if (!$provider_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Provider ID is required'
                ], 400);
            }

            // Get booking provider search records with user details
            $bookingProviderSearch = DB::table('booking_provider_search')
                ->join('users', 'booking_provider_search.user_id', '=', 'users.id')
                ->join('bookings', 'booking_provider_search.booking_id', '=', 'bookings.booking_id')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->join('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                ->select('booking_provider_search.*', 'services.title as service_title', 'sub_services.title as sub_service_title', 
                'bookings.vehicle_image', 'bookings.options', 'bookings.s_latitude', 'bookings.s_longitude', 'bookings.status',
                'users.first_name', 'users.last_name', 'users.email', 'users.profile_photo')
                ->where('booking_provider_search.provider_id', $provider_id)
                ->where('bookings.status', '!=', 'COMPLETED')
                ->orderBy('booking_provider_search.id', 'DESC')
                ->get();

            // Get booking IDs from the search results
            $bookingIds = $bookingProviderSearch->pluck('booking_id');

            // Get bookings data using the booking IDs
            $bookings = DB::table('bookings')
                ->whereIn('booking_id', $bookingIds)
                ->where('status', 'SEARCHING')
                ->orderBy('bookings.id', 'DESC')
                ->get();

            // For each booking, fetch the question value if options contains question_id
            $bookings = $bookings->map(function($booking) {
                $booking = (array) $booking;
                $question_value = null;
                if (!empty($booking['options'])) {
                    $options = json_decode($booking['options'], true);
                    if (is_array($options)) {
                        // If options is an array of answers, loop through
                        if (isset($options[0]['question_id'])) {
                            // If multiple, get the first one (or you can collect all)
                            $question_id = $options[0]['question_id'];
                        } elseif (isset($options['question_id'])) {
                            $question_id = $options['question_id'];
                        } else {
                            $question_id = null;
                        }
                        if ($question_id) {
                            $question = \DB::table('condition_questions')->where('id', $question_id)->value('question');
                            $question_value = $question;
                        }
                    }
                }
                $booking['question_value'] = $question_value;
                return $booking;
            });

            // Get services data
            $services = DB::table('services')
                ->select('id', 'title', 'image', 'description')
                ->whereIn('id', function($query) use ($bookingIds) {
                    $query->select('service_id')
                        ->from('bookings')
                        ->whereIn('booking_id', $bookingIds)
                        ->where('status', 'SEARCHING');
                })
                ->get();

            // Get sub services data
            $subServices = DB::table('sub_services')
                ->select('id', 'service_id', 'title', 'image', 'description')
                ->whereIn('id', function($query) use ($bookingIds) {
                    $query->select('sub_service_id')
                        ->from('bookings')
                        ->whereIn('booking_id', $bookingIds)
                        ->where('status', 'SEARCHING');
                })
                ->get();

            return response()->json([
                'status' => '200',
                'message' => 'Get User Booking Details',
                'data' => [
                    'booking_provider_search' => $bookingProviderSearch,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft delete a provider by updating deleted_at field
     */
    public function deleteProvider(Request $request)
    {
        $provider_id = $request->provider_id;
        if (!$provider_id) {
            return response()->json([
                'status' => false,
                'message' => 'provider_id is required'
            ], 400);
        }
        $provider = \App\Models\Provider::find($provider_id);
        if (!$provider) {
            return response()->json([
                'status' => false,
                'message' => 'Provider not found'
            ], 404);
        }
        $provider->deleted_at = now();
        $provider->save();
        return response()->json([
            'status' => 200,
            'message' => 'Provider deleted successfully',
            'provider_id' => $provider_id,
            'deleted_at' => $provider->deleted_at
        ]);
    }
	/*
	*
	* Send message to user
	*/
   public function sendMessages(Request $request)
    {
        /*try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'from_id' => 'required|numeric',
                'to_id' => 'required|numeric',
                'body' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                $message = Message::create([
                    'from_id' => $request->from_id,
                    'to_id' => $request->to_id,
                    'body' => $request->body,
                ]);
                $message->save();
                return response()->json([
                    'status' => '200',
                    'message' => 'Message sent successfully',
                    'data' => $message
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in sendMessage: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }*/
		
		try {
    // Validate request
    $validator = Validator::make($request->all(), [
        'from_id' => 'required|numeric',
        'to_id' => 'required|numeric',
        'booking_id' => 'required|string',
        'body' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => '422',
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ], 422);
    }

    $fromId = $request->from_id;
    $toId = $request->to_id;
    $booking_id = $request->booking_id;

    // Find existing message thread regardless of order
    $messageThread = Message::where(function ($query) use ($fromId, $toId, $booking_id) {
        $query->where('from_id', $fromId)->where('to_id', $toId)->where('booking_id', $booking_id);
    })->orWhere(function ($query) use ($fromId, $toId, $booking_id) {
        $query->where('from_id', $toId)->where('to_id', $fromId)->where('booking_id', $booking_id);
    })->first();

    $newMessage = [
        'from_id' => $fromId,
        'to_id' => $toId,
        'booking_id' => $booking_id,
        'body' => $request->body,
        'timestamp' => now()->toDateTimeString()
    ];

    if ($messageThread) {
        $bodyArray = $messageThread->body ?? [];
        if (!is_array($bodyArray)) {
            $bodyArray = json_decode($bodyArray, true);
        }
        $bodyArray[] = $newMessage;
		$messageThread->from_id = $fromId;
		$messageThread->to_id = $toId;
		$messageThread->booking_id = $booking_id;
        $messageThread->body = json_encode($bodyArray);
        $messageThread->save();
    } else {
        $messageThread = Message::create([
            'from_id' => $fromId,
            'to_id' => $toId,
            'booking_id' => $booking_id,
            'body' => json_encode([$newMessage]),
        ]);
    }

    return response()->json([
        'status' => '200',
        'message' => 'Message saved successfully',
        'data' => $messageThread
    ]);
} catch (\Exception $e) {
    \Log::error('Error in sendMessage: ' . $e->getMessage());
    return response()->json([
        'status' => '500',
        'message' => 'Something went wrong',
        'error' => $e->getMessage()
    ], 500);
}

    }


	/*
	* Fetch messages from user
	*/
    public function fetchMessages(Request $request)
    {
        $request->validate([
            'to_id' => 'required|integer'
        ]);
		$to_id = $request->to_id;
		$from_id = $request->from_id;
		$booking_id = $request->booking_id;
		
		$messages = Message::where('from_id', $from_id)
				->where('to_id', $to_id)
				->where('booking_id', $booking_id)
				->get()
				->map(function ($message) {
					// Decode the JSON body string into an array
					$message->body = json_decode($message->body, true);
					return $message;
				});				
        if ($messages->isEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'No messages found for this user',
            ], 200);
        }
 
        return response()->json([
            'status' => 200,
            'message' => 'Messages retrieved successfully',
            'data' => $messages,
        ], 200);
		
    }
    /*
	* Check last review
	*/
	public function checkReview()
	{
		try{
			$provider = auth()->user();
			
			$booking = Booking::where('provider_id', $provider->id)
			->join('users', 'bookings.user_id', '=', 'users.id')
			->select(
			'bookings.id',
			'bookings.booking_id as bookingId',
			'bookings.user_id',
			'bookings.provider_id',
			'bookings.provider_review',
			'users.first_name as firstName',
			'users.last_name as lastName'
			)
			->where('bookings.status', 'COMPLETED')
			->latest('bookings.created_at')
			->first();
			if ($booking && ($booking->provider_review!=NULL)) {
                $data = ['review' => 1];
            } else {
                $data = $booking;
				$data['review'] = 0;
				$data['dd'] = $booking->provider_review;
            }
            
			 return response()->json([
            'status' => 200,
            'message' => 'Fetch Review Data.',
            'data' => $data,
            ], 200);
		}
		catch (\Exception $e) {
            \Log::error('Error in updateProvider: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
	}
   /*
	* Redirect screen and return variables
	*/
	public function redirectScreen(Request $request)
    {
        try {
            $provider_id = $request->provider_id;
            $redirect_screen = '';
            $providerStatus = '';
            $data = [];

            if (!$provider_id) {
                return response()->json([
                    'status' => 400,
                    'message' => 'provider detail is required',
                    'data' => null
                ], 400);
            }

            // 1. Check last record from booking_provider_search for this provider
            $lastBps = \DB::table('booking_provider_search')
                ->where('provider_id', $provider_id)
                ->where('skip_job', 0)
                ->orderByDesc('updated_at')
                ->first();

            $booking = null;
            if ($lastBps) {
                $booking = \DB::table('bookings')
                    ->where('booking_id', $lastBps->booking_id)
                    ->orderByDesc('updated_at')
                    ->first();
            }

            // 1. ProviderBid screen
            if ($lastBps && $booking && $lastBps->bid_placed == 1 && $booking->status == 'SEARCHING') {
                $redirect_screen = 'ProviderBid';
            } else {
                // 2. Find last record for provider_id from bookings table
                $lastBooking = \DB::table('bookings')
                    ->where('provider_id', $provider_id)
                    ->orderByDesc('updated_at')
                    ->first();
                if ($lastBooking) {
                    // a. status = CONFIRMED
                    if ($lastBooking->status == 'CONFIRMED') {
                        $redirect_screen = 'ProviderStatus';
                        if ($lastBooking->provider_status == 'ARRIVED')
                        {
                            $providerStatus = 'arrived';
                        }
                        
                        //if ($lastBooking->provider_status == 'ARRIVED' || //$lastBooking->provider_status == 'STARTED') 
                        if ($lastBooking->provider_status == 'STARTED'){
                        $redirect_screen = 'ProviderStatus';
                        $providerStatus = 'start';
                        // Get before_work_proof, after_work_proof, signature, paid, provider_rated
                        $before_work_proof = $lastBooking->before_work_proof;
                        //$after_work_proof = $lastBooking->after_work_proof;
                        //$signature = $lastBooking->signature;
                        if (empty($before_work_proof)) {
                            $redirect_screen = 'ProviderOTP';
                            $providerStatus = '';
                            }
                        }
                        
                    }
                    // b. status = ARRIVED
                    /*elseif ($lastBooking->provider_status == 'ARRIVED') {
                        $redirect_screen = 'ProviderStatus';
                        $providerStatus = 'start';
                    }*/
                    // c. status = STARTED
                    elseif ($lastBooking->status == 'STARTED') {
                        // Get before_work_proof, after_work_proof, signature, paid, provider_rated
                       $before_work_proof = $lastBooking->before_work_proof;
                        $after_work_proof = $lastBooking->after_work_proof;
                        $signature = $lastBooking->signature;
                        /*if (empty($before_work_proof)) {
                            $redirect_screen = 'ProviderOTP';
                        } else*/
                        
                        if (!empty($before_work_proof) && empty($after_work_proof)) {
                            $redirect_screen = 'WorkProof';
                        } elseif (!empty($before_work_proof) && !empty($after_work_proof) && empty($signature)) {
                            $redirect_screen = 'ProviderSignature';
                        } 
                    }
                    elseif ($lastBooking->status == 'COMPLETED') {
                        $before_work_proof = $lastBooking->before_work_proof;
                        $after_work_proof = $lastBooking->after_work_proof;
                        $signature = $lastBooking->signature;
                        $paid = $lastBooking->paid;
                        $provider_rated = $lastBooking->provider_rated;
                        if (!empty($before_work_proof) && !empty($after_work_proof) && !empty($signature) && ($paid == 0 || $lastBooking->provider_status=='STARTED')) {
                            $redirect_screen = 'WorkSummary';
                        } elseif (!empty($before_work_proof) && !empty($after_work_proof) && !empty($signature) && ($paid == 1 || $lastBooking->provider_status=='COMPLETED') && $provider_rated == 0) {
                            $redirect_screen = 'ProviderRating';
                        }
                    }
                }
            }

            // Prepare $data object
            $bookingId = null;
            $firstName = null;
            $lastName = null;
            $distance = null;
            $price = null;
            $s_latitude = null;
            $s_longitude = null;
            $status = $providerStatus;

            // Use the most relevant booking (lastBooking or $booking)
            $targetBooking = isset($lastBooking) && $lastBooking ? $lastBooking : $booking;
            if ($targetBooking) {
                $bookingId = $targetBooking->booking_id;
                $distance = $targetBooking->distance ?? $lastBps->distance;
                $price = $targetBooking->amount ?? null;
                $s_latitude = $targetBooking->s_latitude ?? null;
                $s_longitude = $targetBooking->s_longitude ?? null;
                $user_id = $targetBooking->user_id ?? null;
                if ($user_id) {
                    $user = \DB::table('users')->where('id', $user_id)->first();
                    if ($user) {
                        $firstName = $user->first_name;
                        $lastName = $user->last_name;
                    }
                }
            }

            $data = [
                'redirect_screen' => $redirect_screen,
                'bookingId' => $bookingId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'distance' => $distance !== null ? number_format((float)$distance, 2, '.', '') : null,
                'price' => $price,
                's_latitude' => $s_latitude,
                's_longitude' => $s_longitude,
                'status' => $status
            ];

            return response()->json([
                'status' => 200,
                'message' => 'Redirect Screen.',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in redirectScreen: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}