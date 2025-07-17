<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\Booking;
use App\Models\VehicleType;
use App\Models\Provider;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use DB;
use Session;

class UserController extends Controller
{
    
     public function completeview()
    {
        $completeboooking = Booking::where('status','COMPLETED');
        
       return view('admin.dashboard',compact('completeboooking'));
    }
    
    // vehicle start  from here
    
     public function vehicle()
    {
     
       return view('admin.vehicle.addvehicle');
    }
    
      
    
     public function vehiclelist()
    {
        
        $vehiclelist = VehicleType::get();
     
       return view('admin.vehicle.index',compact('vehiclelist'));
    }
    
    
 public function vehicledelete($id)
    {
        
        $vehicledata = VehicleType::where('id',$id)->delete();
     
        return redirect()->route('admin.vehicle.list')->with('success','Vehicle Delete Successfully!');
    }
    
        
        public function vehicleedit($id)
    {
        
        $vehicledata = VehicleType::where('id',$id)->first();
     
       return view('admin.vehicle.editvehicle',compact('vehicledata'));
    }
    
        


     
      public function vehiclestore(Request $request)
    { 
        $vehicle = new VehicleType;
        
     $vehicle->titlle = $request->title;
     
  if($request->hasFile('image')) {
        $file = $request->file('image');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/vehicle',$filename);
        $vehicle->vihele_image = $filename;
       
 }
 
 $vehicle->save();
 
  return redirect()->route('admin.vehicle.list')->with('success', 'Vehicle Added Successfully!');
 
 
 
    }
    
    
    
     public function vehicleupdate(Request $request)
    { 
        $vehicle = VehicleType::find($request->id);
        
     $vehicle->titlle = $request->title;
     
  if($request->hasFile('image')) {
        $file = $request->file('image');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/vehicle',$filename);
        $vehicle->vihele_image = $filename;
       
 }
 
 $vehicle->update();
 
  return redirect()->route('admin.vehicle.list')->with('success', 'Vehicle Added Successfully!');
 
 
 
    }
    
    
    
    
    
    
    // vehicle end  from here 
    
    
    public function bulkImport()
    {
       return view('admin.user.bulk-import');
    }
    
    public function bulkImportStore(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        Excel::import(new UsersImport, $request->file('file')->store('public/images'));
        return redirect()->route('admin.user')->with('success', 'Bulk User Insert Successfully!');
    }
    
    public function index()
    {
        $userList = User::whereNull('deleted_at')->orderBy('id','DESC')->get();
       
        return view('admin.user.index', compact('userList'));
    }
    
    public function create()
    {
        $country = Country::all();
        return view('admin.user.create',compact('country'));    
    }
    
    
    
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
            'birth_date' => 'required|date_format:Y-m-d|after_or_equal:01-01-1940|before_or_equal:01-01-2005',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'first_name.required' => 'The First Name Field is required',
            'mobile_number.unique' => 'The Mobile Number has already been taken',
            'email.unique' => 'The Email has already been taken',
            'password.required' => 'The Password Field is required'
        ]);
        
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->mobile_number = $request->mobile_number;
        $user->birth_date = date('d-m-Y', strtotime($request->birth_date));
        $user->postcode = $request->postcode;
        $user->password = Hash::make($request->password);
        $imageName = time().'.'.$request->profile_pic->extension();  
        $request->profile_pic->move(public_path('images'), $imageName);
        $user->profile_photo = $imageName;
        $user->save();
        
        return redirect()->route('admin.user')->with('success', 'User Create Successfully!');
    }
    
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        
        if($request->status == '1')
        {
            Session::flash('success', 'User Activate successfully!');
        }
        else
        {
            Session::flash('success', 'User Deactivate successfully!');
        }
        return response()->json(['success' => true, 'url' => '/admin/user'], 200);
    }
    
    /** Soft Delete User **/
    public function delete(Request $request,$id)
    {
        $user = User::where('id',$id)->delete();
        
        return redirect()->route('admin.user')->with('success','User Delete Successfully!');
    }
    
    public function edit(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        $country = Country::all();
        
        return view('admin.user.edit',compact('user','country'));
    }
    
    /** Update User **/
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|unique:users,mobile_number,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'birth_date' => 'required|date_format:Y-m-d|after_or_equal:01-01-1940|before_or_equal:01-01-2005',
        ], [
            'first_name.required' => 'The First Name Field is required',
            'mobile_number.unique' => 'The Mobile Number has already been taken',
            'email.unique' => 'The Email has already been taken',
        ]);
        
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->mobile_number = $request->mobile_number;
        $user->birth_date = $request->birth_date;
        $user->postcode = $request->postcode;
        if($request->profile_pic != '')
        {
            $imageName = time().'.'.$request->profile_pic->extension();  
            $request->profile_pic->move(public_path('images'), $imageName);
            $user->profile_photo = $imageName;
        }
        $user->update();
        
        return redirect()->route('admin.user')->with('success', 'User Update Successfully!');
    }
    
    public function viewProfile($id)
    {
        $user = User::where('id',$id)->first();
        
        return view('admin.user.profile',compact('user'));
    }
    
    /** View Booking History **/
    public function bookingHistory($id)
    {
        $booking = Booking::join('users','bookings.user_id','=','users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->where('users.id',$id)->select('bookings.*','users.first_name as user_first','users.last_name as user_last','services.title as service_name','sub_services.title as sub_title')->orderBy('bookings.id','DESC')->get();
        
        return view('admin.user.bookingHistory',compact('booking'));
    }
    
    
    
    
    
    
      public function cancelledeBookingStatus(Request $request)
    {
        $status = Booking::find($request->id);
        $status->booking_id = $request->bookid;
        $status->status = $request->status;
        $status->update();
        
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
        
        return redirect()->back()->with('success', 'Booking Update Succesfully');
    }
    
    
     public function bookingdelete(Request $request,$id)
    {
        $bookdelete = Booking::where('id',$id)->delete();
        
        return redirect()->back()->with('success','Booking Delete Successfully!');
    }
    
    
        public function userhistoryyy($id)
    {
        $booking = Booking::join('users','bookings.user_id','=','users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->where('users.id',$id)->select('bookings.*','users.first_name as user_first','users.last_name as user_last','services.title as service_name','sub_services.title as sub_title','bookings.status','bookings.created_at')->orderBy('bookings.id','DESC')->get();
        
        return view('admin.user.userbookinghistory',compact('booking'));
    }
    
    public function bookingservice(Request $request)
    
    {
       
            $booking = new Booking;
            
           $booking->booking_id = "BLK".rand(1000, 9999).date('dmY');
           $booking->user_id = $request->user_id;
           $booking->service_id = $request->service_id;
           $booking->sub_service_id = $request->sub_service_id;
           $booking->booking_type = $request->bookingtype;;
           
          
        $booking->amount = $request->amount;

           
           $booking->schedule_date = date('Y-m-d', strtotime($request->schedule_date));
           $booking->schedule_start = $request->schedule_start;
           $booking->schedule_end = $request->schedule_end;
           $booking->person = $request->person;
           $booking->vehicle_no = $request->vehicle_no;
           $booking->s_latitude = $request->user_latitude;
           $booking->s_longitude = $request->user_longitude;
           
           $booking->save();

           $booking->save();
           
           $provider = Provider::where('business_type',$request->service_id)->where('service_type',$request->sub_service_id)->get();
           
           
       
           
        return redirect()->route('admin.bookingHistory')->with('success','Booking Created Successfully!');
        
    
       

    }
   
    
}