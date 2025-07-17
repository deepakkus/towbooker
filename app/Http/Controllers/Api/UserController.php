<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\Country;
use App\Models\Service;
use App\Models\SubService;
use App\Models\Policy;
use App\Models\Message;
use App\Models\UserAnswer;
use App\Models\Booking;
use App\Models\Provider;
use App\Models\Banner;
use App\Models\DressCode;
use App\Models\AppSetting;
use App\Models\UserWalletHistory;
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\ResetPassword;
use DB;

class UserController extends Controller
{
    /** For Country Phone Code Start **/
    public function getCountryCode()
    {
        $code = Country::all();
        return response()->json(['status' => '200', 'message' => 'Country Code','data' => $code]);
    }
    /** For Country Phone Code End **/
    
    /** For User Create Account Start **/
    public function createUser(Request $request)
    {
        $checkEmail = User::where('email',trim($request->email))->get();
        $checkMobile = User::where('mobile_number',$request->mobile_number)->withTrashed()->get();

        if(count($checkEmail) != '0')
        {
            return response()->json(['status' => '422', 'message' => 'This Email is already exists']);
        }
        elseif(count($checkMobile) != '0')
        {
            return response()->json(['status' => '422', 'message' => 'This Mobile Number is already exists']);       
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country_code' => $request->code,
            'mobile_number' => $request->mobile_number,
            'birth_date' => $request->birth_date,
            'postcode' => $request->postcode,
            'password' => Hash::make($request->password),
            'device_token' => $request->token,
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
                    
        mail($to,$subject,$message,$headers);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => '200', 'data' => $user,'access_token' => $token, 'token_type' => 'Bearer' ]);   
    }
    /** For User Create Account End **/
    
    /** For User Email Login Start **/
    public function emailLogin(Request $request)
    {
        $device = $request->token;
        if (!Auth::attempt($request->only('email', 'password')))
        {
            //return response()->json(['status' => '401', 'message' => 'Unauthorized']);
            return response()->json(['status' => '401', 'message' => 'Wrong Login Credentials.']);
        }
        
        $user = User::where('email', $request['email'])->firstOrFail();
        $user->device_token = $device;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', ]);
    }
    /** For User Email Login End **/
    
    /** For User Forgot Password Start **/
    protected function forgotPassword(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email|exists:users,email"
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        /*$response =  Password::sendResetLink($input);
        if($response == Password::RESET_LINK_SENT)
        {
            $message = "Mail send successfully";
        }else
        {
            $message = "Email could not be sent to this email address";
        }*/
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        //$response = ['status' => '200', 'data'=>'','message' => $message];
        //return response($response, 200);
        $user = User::where('email', $request->email)->first();
        
        $token = Password::createToken($user);
		$mailMessage = (new ResetPassword($token))->toMail($user);
		$to = $request->email;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
        // More headers
        $headers .= 'From: "Towneeds" <mechanic@grabahamas.com>' . "\r\n";
		
		$subject = $mailMessage->subject. ' for Provider';
        $line = $mailMessage->introLines[0]; // First line of the email
        $actionText = $mailMessage->actionText; // Button text
        $actionUrl = $mailMessage->actionUrl;  // Reset password URL
        $mail_message = '<div style="background-color:#e0e0d1"><div style="font-size:20px;font-weight:bold;text-align: center;padding-top:10px;margin-bottom:55px">Towneeds</div>';
        $mail_message .= '<div style="margin-left:350px;background-color:#fff;padding-left:20px;padding-top:20px;width:500px"><span style="font-size:20px;font-weight:bold;">Hello!</span>';
        $mail_message .= '<p>'.$line.'</p>';
        $mail_message .= '<a href="'.$actionUrl.'">'.$actionText.'</a>';
        $mail_message .= '<p>'.$mailMessage->outroLines[0].'</p>';
        $mail_message .= '<p>'.$mailMessage->outroLines[1].'</p>';
        $mail_message .= '<p>Regards,</p>';
        $mail_message .= '<p>Towneeds</p>';
        $mail_message .= '</div>';
        $mail_message .= '</div>';
        if (mail($to, $subject, $mail_message, $headers)) {
            $message = "Mail send successfully";
        } else {
            $message = "Email sending failed.";
        }
        return response()->json(['status' => '200', 'data'=>'','message' => $message]);
    }
    /** For User Forgot Password End **/
    
    /** For Mobile Login Start **/
    /* Send Otp */
    public function sendotp(Request $request)
    {
        $code = $request->code;
        $mobile = $request->mobile_number;
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
                    return response()->json(['status' => '200', 'message' => 'Message Send Successfully','data'=>$otp], 200);
                }
            }
            catch(Exception $e)
            {
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
            }
        }
    }
    
    /* Verify Otp */
    public function verifyOtp(Request $request)
    {
        $code = $request->code;
        $mobile = $request->mobile_number;
        $otp = $request->otp;
        $device = $request->token;
        $otpCheck = User::where('country_code',$code)->where('mobile_number',$mobile)->where('otp',$otp)->orderBy('id','DESC')->first();
        if($otpCheck === null)
        {
            return response()->json(['status' => '404', 'message' => 'Wrong Otp']);
        }
        else
        {
            $user = User::where('country_code',$code)->where('mobile_number', $mobile)->firstOrFail();
            $user->otp = "0";
            $user->device_token = $device;
            $user->save();
            
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['status' => '200', 'message' => 'Hi '.$user->first_name.', Welcome','access_token' => $token, 'token_type' => 'Bearer', ]);
        }
    }
    /** For Mobile Login End **/
    
    /** For User Logout Start **/
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
    /** For User Logout End **/
    
    /** For User Update Profile **/
    public function updateProfile(Request $request)
    {
        $id = $request->user_id;
        $user = User::where('id',$id)->first();
        
        $checkEmail = User::where('id','!=',$id)->where('email',$request->email)->get();
        $checkMobile = User::where('id','!=',$id)->where('mobile_number',$request->mobile_number)->get();

        if(count($checkEmail) != '0')
        {
            return response()->json(['status' => '422', 'message' => 'This Email is already exists']);
        }
        elseif(count($checkMobile) != '0')
        {
            return response()->json(['status' => '422', 'message' => 'This Mobile Number is already exists']);       
        }
        else
        {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->country_code = $request->country_code;
            $user->mobile_number = $request->mobile_number;
            $user->birth_date = $request->birth_date;
            $user->postcode = $request->postcode;
            if($request->profile_photo != '')
            {
                $image = $request->profile_photo;  // your base64 encoded
                $image1 = str_replace('data:image/png;base64,', '', $image);
                $image2 = str_replace(' ', '+', $image1);
                $imageName = time().'.'.'png';
                $path = \File::put(public_path().'/images/' . $imageName, base64_decode($image2));
                $user->profile_photo = url('public/images/'.$imageName);
            }
            $user->save();
            
            return response()->json(['ststus' => '200', 'message' => 'Profile Update Successfully', 'data' => $user]);
        }
        
    }
    /** For User Update Profile **/
    
    /** For User Banner View Start **/
    public function bannerView()
    {
        $banner = Banner::first();
        
        return response()->json(['status' => '200', 'message' => 'Banner', 'data' => $banner]);
    }
    /** For User Banner View End **/
    
    /** For Submit Condition Question Start **/
    public function submitAnswer(Request $request)
    {
        //$answerdata = json_decode($request->input('answerdata'));
        $answerdata = ($request->input('answerdata'));
        //dd($answerdata);
        for($i=0;count($answerdata)>$i;$i++)
        {
            $answer = new UserAnswer;
            // $answer->user_id = $answerdata[$i]->user_id;
            // $answer->service_id = $answerdata[$i]->service_id;
            // $answer->sub_service_id = $answerdata[$i]->sub_service_id;
            // $answer->question_id = $answerdata[$i]->question_id;
            // $answer->answer = $answerdata[$i]->answer;
            $answer->user_id = $answerdata[$i]['user_id'];
            $answer->service_id = $answerdata[$i]['service_id'];
            $answer->sub_service_id = $answerdata[$i]['sub_service_id'];
            $answer->question_id = $answerdata[$i]['question_id'];
            $answer->answer = $answerdata[$i]['answer'];
            $answer->save();
        }
        return response()->json(['status' => '200', 'message' => 'Answers', 'data' => $answer]);
    }
    /** For Submit Condition Question End **/
    
    /** For User Get Dress Code Start **/
    public function getDressCode()
    {
        $dressCode = DressCode::all();
        
        return response()->json(['status' => '200', 'message' => 'Dress Code', 'data' => $dressCode]);
    }
    /** For User Get Dress Code End **/
    
    /** For User Booking Start **/
    public function serviceBook(Request $request)
    {
        $appSettings = AppSetting::where('id', '1')->first();
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => "required|numeric",
            'service_id' => "required|numeric",
            'sub_service_id' => "required|numeric",
            'booking_type' => "required|numeric",
        ]);
        $book_type = $request->booking_type;
        
        if($book_type == '0')
        {
           $booking = new Booking; 
           $booking->booking_id = "BLK".rand(1000, 9999).date('dmY');
           $booking->user_id = $request->user_id;
           $booking->service_id = $request->service_id;
           $booking->sub_service_id = $request->sub_service_id;
           $booking->booking_type = '0';
           $booking->s_address = $request->s_address;
           $booking->s_latitude = $request->s_latitude;
           $booking->s_longitude = $request->s_longitude;
           $booking->options = $request->answerdata;
           $booking->save();

           // Find nearest providers and insert into booking_provider_search
           $searchRequest = new Request([
               'latitude' => $request->s_latitude,
               'longitude' => $request->s_longitude
           ]);
           $nearestProviders = $this->findNearestbooking($searchRequest);
           $providers = json_decode($nearestProviders->getContent(), true)['data'];
           
           foreach($providers as $provider) {
               DB::table('booking_provider_search')->insert([
                   'booking_id' => $booking->booking_id,
                   'user_id' => $request->user_id,
                   'provider_id' => $provider['id'],
                   'price' => $request->price,
                   'created_at' => now(),
                   'updated_at' => now()
               ]);
           }
           
           $provider = Provider::where('business_type',$request->service_id)->where('service_type',$request->sub_service_id)->get();
           
           return response()->json(['status' => '200', 'message' => 'Provider Searching', 'data' => $booking, 'provider' => $provider,'msg'=>"Thank you for service book"]);
        }
        elseif($book_type == '1')
        {
           $booking = new Booking; 
           $booking->booking_id = "BLK".rand(1000, 9999).date('dmY');
           $booking->user_id = $request->user_id;
           $booking->service_id = $request->service_id;
           $booking->sub_service_id = $request->sub_service_id;
           $booking->booking_type = '1';
           $booking->s_address = $request->s_address;
           $booking->s_latitude = $request->s_latitude;
           $booking->s_longitude = $request->s_longitude;
           $booking->schedule_date = date('Y-m-d', strtotime($request->schedule_date));
           $booking->schedule_start = $request->schedule_start;
           $booking->schedule_end = $request->schedule_end;
           $booking->person = $request->person;
           $booking->options = $request->answerdata;
           $booking->save();

           // Find nearest providers and insert into booking_provider_search
           $searchRequest = new Request([
               'latitude' => $request->s_latitude,
               'longitude' => $request->s_longitude
           ]);
           $nearestProviders = $this->findNearestbooking($searchRequest);
           $providers = json_decode($nearestProviders->getContent(), true)['data'];
           
           foreach($providers as $provider) {
               DB::table('booking_provider_search')->insert([
                   'booking_id' => $booking->booking_id,
                   'user_id' => $request->user_id,
                   'provider_id' => $provider['id'],
                   'price' => $request->price,
                   'created_at' => now(),
                   'updated_at' => now()
               ]);
           }
           
           return response()->json(['status' => '200', 'message' => 'Schedule Book', 'data' => $booking,'msg'=>"Thank you for service book"]);
        }
        else
        {
            $booking = new Booking; 
            $booking->booking_id = "BLK".rand(1000, 9999).date('dmY');
            $booking->user_id = $request->user_id;
            $booking->service_id = $request->service_id;
            $booking->sub_service_id = $request->sub_service_id;
            $booking->booking_type = '2';
            $booking->amount = $request->price;
            $booking->s_address = $request->s_address;
            $booking->s_latitude = $request->s_latitude;
            $booking->s_longitude = $request->s_longitude;
            $booking->schedule_date = date('Y-m-d', strtotime($request->schedule_date));
            $booking->schedule_start = $request->schedule_start;
            $booking->schedule_end = $request->schedule_end;
            $booking->person = $request->person;
            $booking->dress_code = '1';
            $booking->additional_information = $request->additional;
            if($request->vehicle_image != '' || $request->vehicle_image)
            {
                $image = $request->vehicle_image;  // your base64 encoded
                
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
                    
                    $filePath = public_path('vehicle/' . $imageName);
                    file_put_contents($filePath, $decodedImage);

                    // Save image URL
                    $booking->vehicle_image = url('public/vehicle/' . $imageName);
                }
            }
            if($request->vehicle_image1 != '')
            {
                $imagee = $request->vehicle_image1;  // your base64 encoded
                $imagee1 = str_replace('data:image/png;base64,', '', $imagee);
                $imagee2 = str_replace(' ', '+', $imagee1);
                $imageNamee = time().'.'.'png';
                $path = \File::put(public_path().'/vehicle/' . $imageNamee, base64_decode($imagee2));
                $booking->vehicle_image1 = url('public/vehicle/'.$imageNamee);
            }
            if($request->vehicle_image2 != '')
            {
                $imageee = $request->vehicle_image2;  // your base64 encoded
                $imageee1 = str_replace('data:image/png;base64,', '', $imageee);
                $imageee2 = str_replace(' ', '+', $imageee1);
                $imageNameee = time().'.'.'png';
                $path = \File::put(public_path().'/vehicle/' . $imageNameee, base64_decode($imageee2));
                $booking->vehicle_image2 = url('public/vehicle/'.$imageNameee);
            }
            if($request->vehicle_image3 != '')
            {
                $imageeee = $request->vehicle_image3;  // your base64 encoded
                $imageeee1 = str_replace('data:image/png;base64,', '', $imageeee);
                $imageeee2 = str_replace(' ', '+', $imageeee1);
                $imageNameeee = time().'.'.'png';
                $path = \File::put(public_path().'/vehicle/' . $imageNameeee, base64_decode($imageeee2));
                $booking->vehicle_image3 = url('public/vehicle/'.$imageNameeee);
            }
            $booking->vehicle_description = $request->vehicle_description;
            $booking->options = $request->answerdata;
            $booking->save();
            $booking_id = $booking->id;

            // Find nearest providers and insert into booking_provider_search
            try {
                $searchRequest = new Request([
                    'latitude' => $request->s_latitude,
                    'longitude' => $request->s_longitude
                ]);
                $nearestProviders = $this->findNearestbooking($searchRequest);
                $providers = json_decode($nearestProviders->getContent(), true)['data'];
                
                if (!empty($providers)) {
                    foreach($providers as $provider) {
                        $distance_price = $provider['distance'] * $appSettings->distance_price;
                        DB::table('booking_provider_search')->insert([
                            'booking_id' => $booking->booking_id,
                            'user_id' => $request->user_id,
                            'provider_id' => $provider['id'],
                            'price' => $request->price,
                            'distance' => $provider['distance'], // Adding distance from the provider result
                            'distance_price' => $distance_price,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error in booking_provider_search insertion: ' . $e->getMessage());
            }
            
            if($booking)
            {
                $user = User::where('id',$request->user_id)->first();
                if($user->email != '')
                {
                
                $to = $request->email;
                $subject = "Thank You For Booking";
                            
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
                                                                                    <p style='margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 51px;'><span style='font-size:34px;'><strong><span style='font-size:34px;'><span style='color:#2190e3;font-size:34px;'>".$user->first_name." ".$user->last_name."</span></span></strong></span></p>
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
            }
            
            $provider = Provider::where('business_type',$request->service_id)->where('service_type',$request->sub_service_id)->get();
            
            return response()->json(['status' => '200', 'message' => 'Book and Search Provider', 'data' => $booking, 'providers' => $providers,'msg'=>"Thank you for service book"]);
        }
        
    }
    /** For User Booking End **/
    
    /** For Booking Not Accepted Within 30 Sec. Booking Automatic Cancelled Start **/
    public function bookingAutoCancel(Request $request)
    {
        $booking = Booking::where('booking_id',$request->booking_id)->first();
        $booking->status = "CANCELLED";
        $booking->user_status = "CANCELLED";
        $booking->provider_status = "CANCELLED";
        $booking->cancelled_by = "AUTOMATIC";
        $booking->save();
        
        return response()->json(['status' => '200', 'message' => 'Booking Automatic Cancel']);
    }
    /** For Booking Not Accepted Within 30 Sec. Booking Automatic Cancelled Start **/
    
    /** For User Booking Accept & Provider Search Start **/
    public function providerBookingAccept(Request $request)
    {
        $bookingid = $request->booking_id;
        
        $check = Booking::where('booking_id',$bookingid)->first();
        if($check->provider_id != 0)
        {
            $bookingdata = Booking::join('users','bookings.user_id','=','users.id')->join('providers','bookings.provider_id','=','providers.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->where('bookings.booking_id',$bookingid)->select('bookings.*','users.first_name as userfirst','users.last_name as userlast','users.email as useremail','sub_services.title as subtitle','sub_services.price as subrate','providers.first_name as providerfirst','providers.last_name as providerlast','providers.country_code','providers.mobile_number','providers.business_name','providers.business_address','providers.rating')->get();
            $arr = json_decode(json_encode($bookingdata), TRUE);
            $items = array();
            for($i=0;count($arr)>$i;$i++)
            {
                $startTime = Carbon::parse($arr[$i]['schedule_start']);
                $endTime = Carbon::parse($arr[$i]['schedule_end']);
                $time = $startTime->diff($endTime)->format('%H');
                
                $items[$i]['id'] = $arr[$i]['id'];
                $items[$i]['booking_id'] = $arr[$i]['booking_id'];
                $items[$i]['username'] = $arr[$i]['userfirst']." ".$arr[$i]['userlast'];
                $items[$i]['useraddress'] = $arr[$i]['s_address'];
                $items[$i]['useremail'] = $arr[$i]['useremail'];
                $items[$i]['service_name'] = $arr[$i]['subtitle'];
                $items[$i]['service_rate'] = $arr[$i]['subrate'];
                $items[$i]['person'] = $arr[$i]['person'];
                $items[$i]['hours'] = $time;
                $items[$i]['total'] = $arr[$i]['subrate'] * $arr[$i]['person'];
                $items[$i]['full_name'] = $arr[$i]['providerfirst']." ".$arr[$i]['providerlast'];
                $items[$i]['mobile'] = $arr[$i]['country_code']."-".$arr[$i]['mobile_number'];
                $items[$i]['business_name'] = $arr[$i]['business_name'];
                $items[$i]['business_address'] = $arr[$i]['business_address'];
                $items[$i]['rating'] = $arr[$i]['rating'];
                $items[$i]['status'] = $arr[$i]['status'];
                $items[$i]['latitude'] = $arr[$i]['d_latitude'];
                $items[$i]['longitude'] = $arr[$i]['d_longitude'];
                $items[$i]['track_latitude'] = $arr[$i]['track_latitude'];
                $items[$i]['track_longitude'] = $arr[$i]['track_longitude'];
            }
            return response()->json(['status' => '200', 'message' => 'Your Booking Accepted', 'data' => $items]);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'Searching', 'data' => []]);
        }
    }
	public function updateFields(Request $request)
	{
		$id = $request->booking_id;
		$status = $request->status;
		$booking = Booking::where('booking_id',$id)->first();
		$booking->status = $status;
        $booking->save();
		return response()->json(['status' => '200', 'message' => $booking->status]);
	}
    /** For User Booking Accept & Provider Search End **/
    
    /** For User Update Booking Status Start **/
    public function updateBookingStatus(Request $request)
    {
        $id = $request->booking_id;
        $status = $request->status;
        if($status == '0')
        {
            // Update Booking Status
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "ACCEPTED";
            $booking->user_status = "ACCEPTED";
            $booking->save();
            
        }
        elseif($status == '1')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "ARRIVED";
            $booking->user_status = "ARRIVED";
            $booking->save(); 
        }
        elseif($status == '2')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "STARTED";
            $booking->user_status = "STARTED";
            $booking->save();
        }
        elseif($status == '3')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "COMPLETED";
            $booking->user_status = "COMPLETED";
            $booking->save();
            
            // Update User Wallet
            $user = User::where('id',$booking->user_id)->first();
            $user->wallet_balance = $user->wallet_balance - $booking->amount;
            $user->save();
            
            // Create User Wallet History
            $service = SubService::where('id',$booking->sub_service_id)->first();
            $transaction = new UserWalletHistory;
            $transaction->user_type = '0';
            $transaction->user_id = $booking->user_id;
            $transaction->amount = $booking->amount;
            $transaction->type = '1';
            $transaction->via = $id;
            $transaction->remark = $booking->amount." Debit on Booking of ".$service->title;
            $transaction->save();
            
            // Update Provider Wallet
            $provider = Provider::where('id',$booking->provider_id)->first();
            $provider->wallet = $provider->wallet + $booking->amount;
            $provider->save();
            
            // Create Provider Wallet History
            $pservice = SubService::where('id',$booking->sub_service_id)->first();
            $ptransaction = new UserWalletHistory;
            $ptransaction->user_type = '1';
            $ptransaction->user_id = $booking->provider_id;
            $ptransaction->amount = $booking->amount;
            $ptransaction->type = '0';
            $ptransaction->via = $id;
            $ptransaction->remark = $booking->amount." Credit on Booking of ".$service->title;
            $ptransaction->save();
        }
        elseif($status == '4')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "DROPPED";
            $booking->user_status = "DROPPED";
            $booking->save();
        }
        elseif($status == '5')
        {
            $booking = Booking::where('booking_id',$id)->first();
            $booking->status = "CANCELLED";
            $booking->user_status = "CANCELLED";
            $booking->provider_status = "CANCELLED";
            $booking->cancelled_by = "USER";
            $booking->save();
        }
        return response()->json(['status' => '200', 'message' => $booking->user_status]);
    }
    /** For User Update Booking Status End **/
    
    /** For User Invoice Start **/
    public function userInvoice(Request $request)
    {
        $bookingid = $request->booking_id;
        $check = Booking::where('booking_id',$bookingid)->first();
        if($check->provider_id != 0)
        {
            $bookingdata = Booking::join('users','bookings.user_id','=','users.id')
			->join('providers','bookings.provider_id','=','providers.id')
			->join('services','bookings.service_id','=','services.id')
			->join('sub_services','bookings.sub_service_id','=','sub_services.id')
			->where('bookings.booking_id',$bookingid)
			->select('bookings.*',
			'users.first_name as userfirst',
			'users.last_name as userlast',
			'users.email as useremail',
			'services.id as serviceid',
			'sub_services.id as subid',
			'sub_services.title as subtitle',
			'sub_services.price as subrate',
			'sub_services.description as subdescription',
			'sub_services.image as subimage',
			'providers.first_name as providerfirst',
			'providers.last_name as providerlast',
			'providers.country_code as country_code',
			'providers.mobile_number as mobile',
			'providers.business_name',
			'providers.business_address',
			'providers.rating')->get();
            $arr = json_decode(json_encode($bookingdata), TRUE);
            $items = array();
            for($i=0;count($arr)>$i;$i++)
            {
                $startTime = Carbon::parse($arr[$i]['schedule_start']);
                $endTime = Carbon::parse($arr[$i]['schedule_end']);
                $time = $startTime->diff($endTime)->format('%H');
                
                $items[$i]['id'] = $arr[$i]['id'];
                $items[$i]['booking_id'] = $arr[$i]['booking_id'];
                $items[$i]['username'] = $arr[$i]['userfirst']." ".$arr[$i]['userlast'];
                $items[$i]['useraddress'] = $arr[$i]['s_address'];
                $items[$i]['useremail'] = $arr[$i]['useremail'];
                $items[$i]['serviceid'] = $arr[$i]['serviceid'];
                $items[$i]['subid'] = $arr[$i]['subid'];
                $items[$i]['service_name'] = $arr[$i]['subtitle'];
                //$items[$i]['service_rate'] = $arr[$i]['subrate'];
                $items[$i]['service_rate'] = $arr[$i]['amount'];
                $items[$i]['service_description'] = $arr[$i]['subdescription'];
                $items[$i]['service_image'] = $arr[$i]['subimage'];
                $items[$i]['person'] = $arr[$i]['person'];
                $items[$i]['hours'] = $time;
                $items[$i]['total'] = $arr[$i]['subrate'] * $arr[$i]['person'];
                $items[$i]['full_name'] = $arr[$i]['providerfirst']." ".$arr[$i]['providerlast'];
                //$items[$i]['mobile'] = ($arr[$i]['country_code'])?"-":""//.$arr[$i]['mobile'];
                $items[$i]['mobile'] = ($arr[$i]['mobile']);
                $items[$i]['business_name'] = $arr[$i]['business_name'];
                $items[$i]['business_address'] = $arr[$i]['business_address'];
                $items[$i]['rating'] = $arr[$i]['rating'];
                $items[$i]['status'] = $arr[$i]['status'];
                $items[$i]['latitude'] = $arr[$i]['d_latitude'];
                $items[$i]['longitude'] = $arr[$i]['d_longitude'];
                $items[$i]['invoice_date'] = date('d-m-Y', strtotime($arr[$i]['created_at']));
            }
            return response()->json(['status' => '200', 'message' => 'Your Booking Invoice', 'data' => $items]);
        }
    }
    /** For User Invoice End **/
    
    /** For User Submit Review Start **/
    public function submitReview(Request $request)
    {
        $id = $request->booking_id;
        $rating = $request->user_rating;
        $review = $request->user_review;
       
        $booking = Booking::where('booking_id',$id)->first();
        $booking->user_rated = $rating;
        $booking->user_review = $review;
        $booking->save();
       
        return response()->json(['status' => '200', 'message' => 'Review Submitted Successfully']);
    }
    /** For User Submit Review End **/
    
    /** For User Get Booking History Start **/
    public function bookingHistory(Request $request)
    {
        $userid = $request->user_id;
        // $booking = Booking::join('services','bookings.service_id','=','services.id')
        // ->join('sub_services','bookings.sub_service_id','=','sub_services.id')
        // ->select('bookings.*','services.title as service_name','services.image as service_image',
        // 'sub_services.title as sub_title','sub_services.image as sub_image')
        // ->where('bookings.user_id',$userid)->where('cancelled_by','!=','AUTOMATIC')
        // ->orderBy('bookings.id','DESC')->get();
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
            ->where('bookings.user_id',$userid)
            ->where('cancelled_by','!=','AUTOMATIC')
            ->orderBy('bookings.id','DESC')
            ->get();
        $arr = json_decode(json_encode($booking), TRUE);
        $items = array();
        for($i=0;count($arr)>$i;$i++)
        {
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
            $items[$i]['money'] = $arr[$i]['amount'];
            $items[$i]['status'] = $arr[$i]['status'];
            $items[$i]['provider_rated'] = $arr[$i]['provider_rated'];
            //$items[$i]['fullname'] = $arr[$i]['provider_first_name'] . ' ' . $arr[$i]['provider_last_name'];
        }
        
        return response()->json(['status' => '200', 'message' => 'User Booking History', 'data' => $items]);
    }
    /** For User Get Booking History End **/
    
    /** For User Get Booking in Details Start **/
    public function bookingDetail(Request $request)
    {
        $userid = $request->user_id;
        $bookingid = $request->booking_id;
        
        $booking = Booking::join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->join('dress_codes','bookings.dress_code','=','dress_codes.id')->select('bookings.*','services.title as service_name','services.image as service_image','sub_services.title as sub_title','sub_services.image as sub_image','dress_codes.title as dress_title','dress_codes.image as dress_image')->where('bookings.user_id',$userid)->where('bookings.booking_id',$bookingid)->get();
        
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
        
        return response()->json(['status' => '200', 'message' => 'User Booking in Detail', 'data' => $arr]);
        
    }
    /** For User Get Booking in Details End **/
    
    /** For User Add Fund in Wallet Start **/
    public function addFund(Request $request)
    {
        $admin = Admin::where('id','1')->first();
        $admin_wallet = $admin->wallet + $request->amount;
        $admin->wallet = $admin_wallet;
        $admin->update();
        
        $transaction = new UserWalletHistory;
        $transaction->user_type = '0';
        $transaction->user_id = $request->user_id;
        $transaction->amount = $request->amount;
        $transaction->type = '0';
        $transaction->via = 'Credit Card';
        $transaction->remark = $request->amount." Credit in wallet";
        $transaction->save();
        
        $user = User::where('id',$request->user_id)->first();
        $wallet = $user->wallet_balance + $request->amount;
        $user->wallet_balance = $wallet;
        $user->save();
        
        return response()->json(['status' => '200', 'message' => 'Fund Add Successfully', 'data' => $user]);
        
    }
    /** For User Add Fund in Wallet End **/
    
    /** For User Wallet History Start **/
    public function walletHistory(Request $request)
    {
        $id = $request->id;
        $user = UserWalletHistory::where('user_type','0')->where('user_id',$id)->orderby('id', 'desc')
        ->select('id', 'user_type', 'user_id', 'amount', 'type', 'via', 'status', 'remark',
        DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y') as created_date"),
        DB::raw("DATE_FORMAT(created_at, '%r') as created_time"),
        DB::raw("DATE_FORMAT(updated_at, '%d/%m/%Y') as updated_date"),
        DB::raw("DATE_FORMAT(updated_at, '%r') as updated_time")
        )
        ->get();
        
         
        return response()->json(['status' => '200', 'message' => 'Wallet History', 'data' => $user]);
    }
    /** For User Wallet History End **/
    
    /** For User Review Start **/
    public function userReview(Request $request)
    {
        $userid = $request->id;
        
        $providers = Provider::join('bookings', 'providers.id', '=', 'bookings.provider_id')
            ->where('bookings.user_id', $userid)
            ->select('providers.*')
            ->distinct()
            ->get();

        $providerIds = $providers->pluck('id');

        // Get completed bookings for these providers, eager load the provider relationship
        $reviews = Booking::with('provider')
            ->whereIn('provider_id', $providerIds)
            ->where('user_id', $userid)
            ->where('status', 'COMPLETED')
            ->orderByDesc('id')
            ->get();
        
        $items = [];

        // Loop through each booking
        foreach ($reviews as $review) {
            $items[] = [
                'id' => $review->id,
                'booking_id' => $review->booking_id,
                'rating' => $review->user_rated,
                'review' => $review->provider_review,
                'provider_name' => $review->provider ? $review->provider->first_name.' '.$review->provider->last_name : 'Unknown',  // Add provider name
            ];
        }
        
        return response()->json(['status' => '200', 'message' => 'User Review', 'data' => $items]);
    }
    /** For User Review End **/
    
    /** For Get Policy Start **/
    public function getPolicy()
    {
        $policy = Policy::all();
        return response()->json(['status' => '200', 'message' => 'Page Data', 'data' => $policy]);
    }
    /** For Get Policy End **/
    
    public function appSetting()
    {
        $app = AppSetting::where('id','1')->first();
        
        return response()->json(['status' => '200', 'message' => 'Get Currency Code', 'data' => $app]);
    }

    // under 70km distance bookinng
    
    public function findNearestbooking(Request $request)
    {
        // Default coordinates
        $defaultLatitude = "26.2186";
        $defaultLongitude = "78.2219";
        $defaultRadius = 70; // 70 miles

        // Get values from request or use defaults
        /*$latitude = $request->has('latitude') ? $request->latitude : $defaultLatitude;
        $longitude = $request->has('longitude') ? $request->longitude : $defaultLongitude;*/
        $latitude = $request->input('latitude', $request->input('s_latitude', $defaultLatitude));
$longitude = $request->input('longitude', $request->input('s_longitude', $defaultLongitude));
        $radius = $request->has('radius') ? $request->radius : $defaultRadius;
        
        \Log::info('Finding nearest providers with coordinates:', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius' => $radius
        ]);
        
        // Using 3959 for miles (instead of 6371 for kilometers)
        $query = Provider::selectRaw("id, first_name, last_name, email, latitude, longitude,
                         ( 3959 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance", [$latitude, $longitude, $latitude])
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->offset(0)
            ->limit(20);

        // Log the raw SQL query
        \Log::info('Raw SQL Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $restaurants = $query->get();

        \Log::info('Found providers:', ['count' => $restaurants->count()]);

        return response()->json(['status' => '200', 'message' => 'Nearest Providers', 'data' => $restaurants]);
    }

    public function userConfirmProvider(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'provider_id' => 'required|integer',
            'amount' => 'required|numeric|min:0'
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

            // Get provider's location
            $provider = Provider::where('id', $request->provider_id)
                ->select('latitude', 'longitude')
                ->first();

            if (!$provider) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Provider not found'
                ], 404);
            }

            // Get distance from booking_provider_search table
            $providerSearch = DB::table('booking_provider_search')
                ->where('booking_id', $request->booking_id)
                ->where('provider_id', $request->provider_id)
                ->first();

            if (!$providerSearch) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Provider search record not found'
                ], 404);
            }
           
            // Generate a unique 4-digit OTP
            $booking_otp = str_pad(mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);

            // Update the booking with provider location tracking
            $booking->provider_id = $request->provider_id;
            $booking->amount = $request->amount;
            $booking->booking_otp = $booking_otp;
            $booking->status = 'CONFIRMED';
            $booking->schedule_start = now();
            $booking->distance = $providerSearch->distance;
            $booking->track_latitude = $provider->latitude;  // Update track_latitude with provider's latitude
            $booking->track_longitude = $provider->longitude; // Update track_longitude with provider's longitude
            $booking->save();

            return response()->json([
                'status' => '200',
                'message' => 'Provider confirmed successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'provider_id' => $booking->provider_id,
                    'amount' => $booking->amount,
                    'booking_otp' => $booking_otp,
                    'distance' => $providerSearch->distance,
                    'booking_status' => $booking->status,
                    'track_latitude' => $booking->track_latitude,
                    'track_longitude' => $booking->track_longitude
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in user confirm provider: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /*
    *
    * User Feedback & user 
    *
    */
    public function userFeedback(Request $request) {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string',
                'user_rated' => 'required|numeric|min:1|max:5',
                'user_review' => 'required|string'
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

            // Update the booking with user feedback
            $booking->user_rated = $request->user_rated;
            $booking->user_review = $request->user_review;
            $booking->save();
            
             // Calculate average rating for the provider
            $averageRating = Booking::where('user_id', $booking->user_id)
                ->where('user_rated', '>', 0)
                ->avg('user_rated');

            // Update provider's rating
            $user = User::where('id', $booking->user_id)->first();
            if ($user) {
                $user->rating = round($averageRating, 1);
                $user->save();
            }
            return response()->json([
                'status' => '200',
                'message' => 'Feedback submitted successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'user_rated' => $booking->user_rated,
                    'user_review' => $booking->user_review
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in userFeedback: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get providers for user's searching bookings
     */
    public function getProviders(Request $request)
    {
        try {
            $booking_id = $request->booking_id;
          

            // Get providers from booking_provider_search table
            $providers = DB::table('booking_provider_search')
                ->join('bookings', 'booking_provider_search.booking_id', '=', 'bookings.booking_id')
                ->join('providers', 'booking_provider_search.provider_id', '=', 'providers.id')
                ->where('booking_provider_search.booking_id', $booking_id)
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
                    'booking_provider_search.bid_placed'
                )
                ->get();

            if ($providers->isEmpty()) {
                return response()->json([
                    'status' => '200',
                    'message' => 'No providers found for your searching bookings',
                    'data' => []
                ]);
            }

            return response()->json([
                'status' => '200',
                'message' => 'Providers retrieved successfully',
                'data' => $providers
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getProviders: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking status for a specific booking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookingStatus(Request $request)
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

            // Get booking details with provider's location
            $booking = DB::table('bookings')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->join('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                ->leftJoin('providers', 'bookings.provider_id', '=', 'providers.id')
                ->where('bookings.booking_id', $request->booking_id)
                ->select(
                    'bookings.booking_id',
                    'bookings.status',
                    'bookings.booking_otp',
                    'bookings.provider_id',
                    'bookings.s_latitude as user_latitude',
                    'bookings.s_longitude as user_longitude',
                    'providers.latitude as provider_latitude',
                    'providers.longitude as provider_longitude',
                    'bookings.vehicle_image as vehicle_image'
                )
                ->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Add status message based on booking status
            $status_message = '';
            if ($booking->status === 'CONFIRMED') {
                $status_message = 'The provider will arrive with in 2 minutes be ready to meet him. Please do not cancel booking if you do so it will charge ₹100 a convenience fee.';
            } elseif ($booking->status === 'CANCELLED') {
                $status_message = 'This booking has been cancelled.';
            } elseif ($booking->status === 'COMPLETED') {
                $status_message = 'Your problem has been fixed or service has been done. Please make payment and share your valuable feedback to us.';
            } elseif ($booking->status === 'ARRIVED') {
                $status_message = 'Provider has arrived. please share otp with him. He will start inspection soon.';
            } elseif ($booking->status === 'STARTED') {
                $status_message = 'Provider has started work.';
            } 

            // Add status message to the booking object
            $booking->status_message = $status_message;

            return response()->json([
                'status' => '200',
                'message' => 'Booking status retrieved successfully',
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => '500',
                'message' => 'Error retrieving booking status',
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
            'booking_id' => 'required|exists:booking_provider_search,booking_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '400',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        // Fetch data from bookings
        $booking = DB::table('bookings')
            ->where('booking_id', $request->booking_id)
            ->first();

        if (!$booking) {
            return response()->json([
                'status' => '404',
                'message' => 'Booking search record not found'
            ], 404);
        }
        try {
            $jobSummary = DB::table('booking_provider_search')
                ->join('bookings', 'bookings.booking_id', '=', 'booking_provider_search.booking_id')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->join('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                ->join('providers', 'bookings.provider_id', '=', 'providers.id')
                ->where('booking_provider_search.booking_id', $request->booking_id)
                ->where('booking_provider_search.provider_id', $booking->provider_id)
                ->select(
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
                    'bookings.distance',
                    'providers.latitude as provider_latitude',
                    'providers.longitude as provider_longitude',
                    'services.title as service_title',
                     'services.image as service_image',
                    'services.description as service_description',
                    'sub_services.title as sub_service_title',
                    'sub_services.image as sub_service_image',
                    'sub_services.description as sub_service_description',
                    'sub_services.price as sub_service_price',
                    'booking_provider_search.price as total_price',
                    // 'booking_provider_search.base_price',
                    // 'booking_provider_search.time_price',
                    // 'booking_provider_search.distance_price',
                    'booking_provider_search.distance as provider_distance',
                    DB::raw('COALESCE(booking_provider_search.base_price, 0) as base_price'),
                    DB::raw('COALESCE(booking_provider_search.time_price, 0) as time_price'),
                    DB::raw('COALESCE(booking_provider_search.distance_price, 0) as distance_price')
                )
                ->first();
                      
            if (!$jobSummary) {
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

    /**
     * Get provider details for a specific booking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderDetails(Request $request)
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

            // Get provider details through the booking
            $providerDetails = DB::table('bookings')
                ->join('providers', 'bookings.provider_id', '=', 'providers.id')
                ->where('bookings.booking_id', $request->booking_id)
                ->select(
                    'providers.id',
                    'providers.first_name',
                    'providers.last_name',
                    'providers.email',
                    'providers.mobile_number',
                    'providers.country_code',
                    'providers.profile_picture',
                    'providers.rating',
                    'providers.business_name',
                    'providers.business_address',
                    'providers.business_type',
                    'providers.service_type',
                    'providers.latitude',
                    'providers.longitude',
                    'providers.wallet',
                    'providers.status'
                )
                ->first();

            if (!$providerDetails) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Provider details not found for this booking'
                ], 404);
            }

            return response()->json([
                'status' => '200',
                'message' => 'Provider details retrieved successfully',
                'data' => $providerDetails
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getProviderDetails: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft delete a user by updating deleted_at field
     */
    public function deleteUser(Request $request)
    {
        $user_id = $request->user_id;
        if (!$user_id) {
            return response()->json([
                'status' => false,
                'message' => 'user_id is required'
            ], 400);
        }
        $user = \App\Models\User::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }
        $user->deleted_at = now();
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully',
            'user_id' => $user_id,
            'deleted_at' => $user->deleted_at
        ]);
    }

    /**
     * Update user payment and wallet history
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserPayment(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'payment_id' => 'required|string',
                'user_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update user's wallet balance
            $user = User::findOrFail($request->user_id);
            if($request->type == 0){
                $user->wallet_balance = $user->wallet_balance + $request->amount;
            }
            else
            {
                $user->wallet_balance = $user->wallet_balance - $request->amount;
            }
            $user->save();

            // Create wallet history record
            $walletHistory = new UserWalletHistory();
            $walletHistory->user_id = $request->user_id;
            $walletHistory->user_type = 0; // For user
            $walletHistory->type = '0'; // Credit
            $walletHistory->via = "card";
            $walletHistory->remark = $request->amount ." credit with wallet also payment id is ".$request->payment_id;
            $walletHistory->amount = $request->amount;
            $walletHistory->save();

            return response()->json([
                'status' => '200',
                'message' => 'Payment updated successfully',
                'data' => [
                    'wallet_history' => $walletHistory,
                    'updated_wallet_balance' => $user->wallet_balance,
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in updateUserPayment: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get provider tracking information for a specific booking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderTracker(Request $request)
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

            // Get tracking information from bookings table
            $trackingInfo = DB::table('bookings')
                ->where('booking_id', $request->booking_id)
                ->select(
                    'booking_id',
                    'user_id',
                    'provider_id',
                    'status',
                    'track_latitude',
                    'track_longitude'
                )
                ->first();

            if (!$trackingInfo) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking tracking information not found'
                ], 404);
            }

            return response()->json([
                'status' => '200',
                'message' => 'Provider tracking information retrieved successfully',
                'data' => $trackingInfo
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getProviderTracker: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel a booking
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelBooking(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|string|exists:bookings,booking_id',
                'cancel_reason' => 'required|string',
                'cancel_by' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the booking
            //->where('status', '!=', 'SEARCHING')
            $booking = Booking::where('booking_id', $request->booking_id)
                            ->where('status', '!=', 'COMPLETED')
                            ->first();

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

            return response()->json([
                'status' => '200',
                'message' => 'Booking cancelled successfully',
                'data' => [
                    'booking_id' => $booking->booking_id,
                    'status' => $booking->status,
                    'cancel_reason' => $booking->cancel_reason
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in cancelBooking: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update wallet balances for users and providers based on booking amounts
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWallet(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required|exists:bookings,booking_id',
                'payment_mode' => 'required|string|in:CASH,WALLET,CARD'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => '422',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get booking details
            $booking = Booking::where('booking_id', $request->booking_id)->first();

            if (!$booking) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Booking not found'
                ], 404);
            }

            // Update payment mode in booking
            $booking->payment_mode = $request->payment_mode;
            $booking->paid = 1;
            $booking->save();

            // Update user wallet
            $user = User::where('id', $booking->user_id)->first();
            if ($user) {
                $user->wallet_balance = $user->wallet_balance - $booking->amount;
                $user->save();

                // Create user wallet history
                $userWalletHistory = new UserWalletHistory();
                $userWalletHistory->user_id = $user->id;
                $userWalletHistory->user_type = 0; // For user
                $userWalletHistory->type = '1'; // Debit
                $userWalletHistory->via = "booking";
                $userWalletHistory->remark = $booking->amount . " debited for booking " . $booking->booking_id;
                $userWalletHistory->amount = $booking->amount;
                $userWalletHistory->save();
            }

            // Update provider wallet
            $provider = Provider::where('id', $booking->provider_id)->first();
            if ($provider) {
                $provider->wallet = $provider->wallet + $booking->amount;
                $provider->save();

                // Create provider wallet history
                $providerWalletHistory = new UserWalletHistory();
                $providerWalletHistory->user_id = $provider->id;
                $providerWalletHistory->user_type = 1; // For provider
                $providerWalletHistory->type = '0'; // Credit
                $providerWalletHistory->via = "booking";
                $providerWalletHistory->remark = $booking->amount . " credited for booking " . $booking->booking_id;
                $providerWalletHistory->amount = $booking->amount;
                $providerWalletHistory->save();
            }

            return response()->json([
                'status' => '200',
                'message' => 'Wallets updated successfully',
                'data' => [
                    'user_wallet' => $user ? $user->wallet_balance : null,
                    'provider_wallet' => $provider ? $provider->wallet : null,
                    'payment_mode' => $booking->payment_mode
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in updateWallet: ' . $e->getMessage());
            return response()->json([
                'status' => '500',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
	
	/*
	* Send message to provider
	*
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
    })->orWhere(function ($query) use ($fromId, $toId,$booking_id) {
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
        'data' => [
        'id' => $messageThread->id,
        'from_id' => $messageThread->from_id,
        'to_id' => $messageThread->to_id,
        'booking_id' => $booking_id,
        'body' => json_decode($messageThread->body, true), 
        'created_at' => $messageThread->created_at,
        'updated_at' => $messageThread->updated_at,
		]
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
	* Fetch message sent to the provider
	*
	*/
    public function fetchMessages(Request $request)
    {
        $request->validate([
            'from_id' => 'required|integer',
            'to_id' => 'required|integer',
            'booking_id' => 'required|string',
        ]);
		$from_id = $request->from_id;
        $to_id = $request->to_id;
        $booking_id = $request->booking_id;

        /*$messages = Message::where(function($query) use ($user1_id, $user2_id) {
                $query->where('from_id', $user1_id)
                      ->where('to_id', $user2_id);
            })
            ->orWhere(function($query) use ($user1_id, $user2_id) {
                $query->where('from_id', $user2_id)
                      ->where('to_id', $user1_id);
            })
            ->orderBy('created_at', 'asc') // oldest first, or 'desc' for newest first
            ->get();
		*/
		//$messages = Message::where('from_id', $from_id)
					//->orWhere('to_id', $from_id)
					//->get();
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
			$user = auth()->user();
			$booking = Booking::where('user_id', $user->id)
			->where('status', 'COMPLETED')
			->latest('created_at')
			->first();
			if ($booking && $booking->user_review!=NULL) {
                $data = ['review' => 1];
            } else {
                $data = $booking;
                $data['review'] = 0;
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
            $user_id = $request->user_id;
            $redirect_screen = '';
            $providerStatus = '';
            $data = [];

            if (!$user_id) {
                return response()->json([
                    'status' => 400,
                    'message' => 'User detail is required',
                    'data' => null
                ], 400);
            }

			        
			$booking = \DB::table('bookings')
                    ->leftJoin('services', 'bookings.service_id', '=', 'services.id')
                    ->leftJoin('sub_services', 'bookings.sub_service_id', '=', 'sub_services.id')
                    ->where('user_id', $user_id)
                    ->orderByDesc('bookings.id')
                    ->select('bookings.*', 'services.title as service_title', 'services.id as service_id', 'services.image as service_image', 'sub_services.title as sub_service_title', 'sub_services.id as sub_service_id')
                    ->first();
               
            // 1. ProviderBid screen
            if ($booking && $booking->status == 'SEARCHING') {
                $redirect_screen = 'NearbyDriversScreen';
            } else {
                
                    // a. status = CONFIRMED
                    if ($booking->status == 'CONFIRMED') {
                        $redirect_screen = 'MessageOtpScreen';
                        //$providerStatus = 'arrived';
                    }
                    elseif ($booking->status == 'COMPLETED' && $booking->paid==0) {
						$redirect_screen = 'TripSummaryScreen';
                        
                    }
                    elseif ($booking->status == 'STARTED' && ($booking->provider_status == 'ARRIVED' || $booking->provider_status == 'STARTED')) {
                        $redirect_screen = 'MessageOtpScreen';
                        //$providerStatus = 'arrived';
                    }
					elseif ($booking->status == 'COMPLETED' && $booking->paid==1 && $booking->user_rated==0) {
						$redirect_screen = 'UserRatingScreen';
                        
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
            $serviceTitle = null;
            $serviceId = null;
            $serviceImage = null;
            $subServiceTitle = null;
            $subServiceId = null;
            $answers = null;
            if ($booking) {
                $bookingId = $booking->booking_id;
                $distance = $booking->distance ?? null;
                $price = $booking->amount ?? null;
                $s_latitude = $booking->s_latitude ?? null;
                $s_longitude = $booking->s_longitude ?? null;
                $provider_id = $booking->provider_id ?? null;
                $otp = $booking->booking_otp ?? null;
                // Extract answers from options field
                if (isset($booking->options) && !empty($booking->options)) {
                    $optionsString = $booking->options;
                    // Fix single quotes to double quotes for valid JSON
                    $fixedOptions = preg_replace("/'([^']*?)'/", '"$1"', $optionsString);
                    $decodedOptions = json_decode($fixedOptions, true);
                    $answers = is_array($decodedOptions) ? $decodedOptions : null;
                }
                if ($provider_id) {
                    $provider = \DB::table('providers')->where('id', $provider_id)->first();
                    if ($provider) {
                        $firstName = $provider->first_name;
                        $lastName = $provider->last_name;
                    }
                }
                // Get service and sub_service title, id, and image from joined fields
                $serviceTitle = $booking->service_title ?? null;
                $serviceId = $booking->service_id ?? null;
                $serviceImage = $booking->service_image ?? null;
                if ($serviceImage) {
                    $serviceImage = url('public/vehicle/' . ltrim($serviceImage, '/'));
                } else {
                    $serviceImage = null;
                }
                $subServiceTitle = $booking->sub_service_title ?? null;
                $subServiceId = $booking->sub_service_id ?? null;
            }

            $data = [
                'redirect_screen' => $redirect_screen,
                'booking_id' => $bookingId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'distance' => $distance,
                'price' => $price,
                'otp' => $otp,
				'providerId' => $provider_id,
                //'s_latitude' => $s_latitude,
                //'s_longitude' => $s_longitude,
                'status' => $status,
                'answers' => $answers,
                'selectedCategory' => $serviceTitle,
                'selectedCatID' => $serviceId,
                'selectedSubCategory' => $subServiceTitle,
                'selectedSubCatID' => $subServiceId,
                'imgdataUrl64bit' => $serviceImage,
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
