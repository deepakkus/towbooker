<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Booking;
use App\Models\User;
use App\Models\Provider;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = auth()->guard('admin')->user();
            
            return redirect()->route('admin.dashboard')->with('success', 'You are Login successfully!!');
            
        } else {
            return back()->with('error','your username and password are wrong.');
        }

    }
    
    public function logout()
    {
        auth()->guard('admin')->logout();
        \Session::flush();
        \Session::put('success','You are logout successfully');        
        return redirect()->route('admin');
    }
    
    public function profile()
    {
        $admin = Admin::where('id',Auth::guard('admin')->user()->id)->first();
        $country = Country::all();
        return view('admin.account.profile', compact('admin','country'));
    }
    
    public function updateProfile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        
        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->address = $request->address;
        $admin->country = $request->country;
        $admin->state = $request->state;
        $admin->city = $request->city;
        $admin->pincode = $request->pincode;
        $admin->about = $request->about;
        $admin->update();
        
        return back()->with('success', 'Profile Update Successfully!');
    }
    
    public function changePassword()
    {
        return view('admin.account.change-password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }
    
    public function dashboard()
    {
         $pending = Booking::where('status','PENDING')->get()->count();
        $users = User::whereNull('deleted_at')->get();
        $providers = Provider::whereNull('deleted_at')->get();
        $newbook = Booking::where('status','ACCEPTED')->get();
        $complete = Booking::where('status','COMPLETED')->get();
        $cancel = Booking::where('status','CANCELLED')->get();
        $process = Booking::where('status','SEARCHING')->get();
        $booking = Booking::join('users','bookings.user_id','=','users.id')->orderBy('bookings.id','DESC')->select('bookings.*','users.first_name','users.last_name')->take(10)->get();
        $currency = AppSetting::first();
        return view('admin.dashboard',compact('booking','users','providers','complete','newbook','cancel','process','currency'));
    }
    
}