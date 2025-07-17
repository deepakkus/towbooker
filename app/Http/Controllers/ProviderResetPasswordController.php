<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider; // or your provider model

class ProviderResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.provider-reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
     public function index()
    {
        /*return view('auth.passwords.provider-reset', [
            'token' => $token,
            'email' => $request->email,
        ]);*/
        $provider = Auth::guard('provider')->user(); 
		 return view('provider.dashboard', compact('provider'));
    }
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:providers,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('providers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($provider, $password) {
                $provider->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                //event(new PasswordReset($provider));
                Auth::guard('provider')->login($provider);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('provider.dashboard')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:providers,email',
        ]);

        $status = Password::broker('providers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}

?>