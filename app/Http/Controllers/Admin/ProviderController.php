<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\AppSetting;
use App\Models\UserWalletHistory;
use App\Models\Country;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProvidersImport;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ProviderController extends Controller
{
    
    public function bulkImport()
    {
       return view('admin.provider.bulk-import');
    }
    
    public function bulkImportStore(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        Excel::import(new ProvidersImport, $request->file('file')->store('public/images'));
        return redirect()->route('admin.provider')->with('success', 'Bulk Provider Insert Successfully!');
    }
    
    public function index()
    {
        $provider = Provider::all();
        
        return view('admin.provider.index', compact('provider'));
    }
    
    public function create()
    {
        $country = Country::all();
        return view('admin.provider.create',compact('country'));    
    }

    // add provider    
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
        
        $provider = new Provider;
        $provider->first_name = $request->first_name;
        $provider->last_name = $request->last_name;
        $provider->email = $request->email;
        $provider->country_code = $request->country_code;
        $provider->mobile_number = $request->mobile_number;
        $provider->birth_date = date('d-m-Y', strtotime($request->birth_date));
        $provider->postcode = $request->postcode;
        $provider->sia_license = $request->sia_license;
        $provider->password = Hash::make($request->password);
        $imageName = time().'.'.$request->profile_pic->extension();  
        $request->profile_pic->move(public_path('images'), $imageName);
        $provider->business_name = $request->business_name;
        $provider->incorporation_no = $request->incorporation_no;
        $provider->business_address = $request->business_address;
        $provider->latitude = $request->latitude;
        $provider->longitude = $request->longitude;
        $provider->business_type = $request->business_type;
        $provider->service_type = $request->service_type;
        $provider->job_title = $request->jobtitle;
        $provider->invite_code = $request->invite_code;
        $provider->comapny_name = $request->company_name;
        $provider->company_address = $request->company_add;
        $provider->account_no = $request->account_no;
        $provider->routing_no = $request->routing_name;
        $provider->insurance_no = $request->insurance_no;
        $provider->vehicle_make = $request->vehicle_make;
        $provider->vehicle_name = $request->vehicle_name;
        $provider->vehicle_model = $request->vehicle_model;
        $provider->plate_no = $request->plate_no;
        $provider->engine_no = $request->engine_no;
         
         if($request->hasFile('driving_license')) {
        $file = $request->file('driving_license');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/images/drivinglicense',$filename);
        $provider->driving_license = $filename;
       
 }
  if($request->hasFile('experiance_letter')) {
        $file = $request->file('experiance_letter');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/images/experienceletter',$filename);
        $provider->experience_letter = $filename;
       
 }
  if($request->hasFile('idproofff')) {
        $file = $request->file('idproofff');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/images/idproof',$filename);
        $provider->id_proof = $filename;
       
 }
  if($request->hasFile('add_proof')) {
        $file = $request->file('add_proof');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/images/addressproof',$filename);
        $provider->address_proof = $filename;
       
 }
  if($request->hasFile('rc_card')) {
        $file = $request->file('rc_card');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('public/admin/images/registrationcard',$filename);
        $provider->rc_card = $filename;
       
 }
       
        $provider->save();
        
        return redirect()->route('admin.provider')->with('success', 'Provider Create Successfully!');
    }
    
    
    
    // document of provider
    
    
    public function providerprovider($id)
    {
        
         $document = Provider::where('id',$id)->first();
         
        return view('admin.provider.showdocument',compact('document'));
    }
    
    
    
    public function providerdocumentupdate(Request $request)
    {
         $provider = Provider::find($request->id);
        if($provider->approval_status == '0')
        {
            $provider->approval_status = '1';
        }
        else
        {
            $provider->approval_status = '0';
        }
        $provider->save();
       
          return response()->json(['status' => '200', 'message' => 'Status Update Successfully', 'data' => $provider->approval_status]);
    }
    
    
    
    
    
    // end document of provider
    
    
    
    
    
    
    // update provider
    
     public function updateprovider(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'birth_date' => 'required|date_format:Y-m-d|after_or_equal:01-01-1940|before_or_equal:01-01-2005',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'first_name.required' => 'The First Name Field is required',
            'mobile_number.unique' => 'The Mobile Number has already been taken',
            'email.unique' => 'The Email has already been taken',
        ]);
        
        $provider = Provider::find($request->id);
        
        $provider->first_name = $request->first_name;
        $provider->last_name = $request->last_name;
        $provider->email = $request->email;
        $provider->country_code = $request->country_code;
        $provider->mobile_number = $request->mobile_number;
        $provider->birth_date = date('d-m-Y', strtotime($request->birth_date));
        $provider->postcode = $request->postcode;
        $provider->sia_license = $request->sia_license;
        $imageName = time().'.'.$request->profile_pic->extension();  
        $request->profile_pic->move(public_path('images'), $imageName);
        $provider->business_name = $request->business_name;
        $provider->incorporation_no = $request->incorporation_no;
        $provider->business_address = $request->business_address;
        $provider->latitude = $request->latitude;
        $provider->longitude = $request->longitude;
        $provider->business_type = $request->business_type;
        $provider->service_type = $request->service_type;
        $provider->job_title = $request->jobtitle;
        $provider->invite_code = $request->invite_code;
        $provider->comapny_name = $request->company_name;
        $provider->company_address = $request->company_add;
        $provider->account_no = $request->account_no;
        $provider->routing_no = $request->routing_name;
        $provider->insurance_no = $request->insurance_no;
        $provider->vehicle_make = $request->vehicle_make;
        $provider->vehicle_name = $request->vehicle_name;
        $provider->vehicle_model = $request->vehicle_model;
        $provider->plate_no = $request->plate_no;
        $provider->engine_no = $request->engine_no;
         
         if($request->hasFile('driving_license')) {
        $file = $request->file('driving_license');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('assets/admin/images/drivinglicense',$filename);
        $provider->driving_license = $filename;
       
 }
  if($request->hasFile('experiance_letter')) {
        $file = $request->file('experiance_letter');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('assets/admin/images/experienceletter',$filename);
        $provider->experience_letter = $filename;
       
 }
  if($request->hasFile('idproofff')) {
        $file = $request->file('idproofff');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('assets/admin/images/idproof',$filename);
        $provider->id_proof = $filename;
       
 }
  if($request->hasFile('add_proof')) {
        $file = $request->file('add_proof');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('assets/admin/images/addressproof',$filename);
        $provider->address_proof = $filename;
       
 }
  if($request->hasFile('rc_card')) {
        $file = $request->file('rc_card');
        $name = $file->getClientOriginalExtension();
        $filename =time().'.'.$name;
        $file->move('assets/admin/images/registrationcard',$filename);
        $provider->rc_card = $filename;
       
 }
       
        $provider->save();
        
        return redirect()->route('admin.provider')->with('success', 'Provider Update Successfully!');
    }
    
    
    
         
    
    /** Soft Delete provider **/
    public function deleteproviderr(Request $request,$id)
    {
        $user = Provider::where('id',$id)->delete();
        
        return redirect()->route('admin.provider')->with('success','Provider Delete Successfully!');
    }
    
   
    
    
    public function viewname($id)
    {
        $view = AppSetting::where('id',$id)->get()->first();
        
        
        return view('admin.layouts.admin',compact('view'));
    }
    
     public function editprovider($id)
    {
        $editt = Provider::where('id',$id)->get()->first();
        
         $country = Country::all();
         
        return view('admin.provider.edit',compact('editt','country'));
    }
    
    
    
    /** Update User **/
   
    
     public function pendingRequest()
    {
        $withdraw = UserWalletHistory::join('providers','user_wallet_histories.user_id','=','providers.id')->select('user_wallet_histories.*','providers.first_name','providers.last_name','providers.wallet')->where('user_wallet_histories.type','2')->where('user_wallet_histories.user_type','1')->where('user_wallet_histories.status','0')->orderBy('user_wallet_histories.id','DESC')->get();
        return view('admin.provider.pending',compact('withdraw'));
    }
    
    public function approveRequest()
    {
        $withdraw = UserWalletHistory::join('providers','user_wallet_histories.user_id','=','providers.id')->select('user_wallet_histories.*','providers.first_name','providers.last_name','providers.wallet')->where('user_wallet_histories.type','2')->where('user_wallet_histories.user_type','1')->where('user_wallet_histories.status','1')->orderBy('user_wallet_histories.id','DESC')->get();
        return view('admin.provider.approve',compact('withdraw'));
    }
    
    public function declineRequest()
    {
        $withdraw = UserWalletHistory::join('providers','user_wallet_histories.user_id','=','providers.id')->select('user_wallet_histories.*','providers.first_name','providers.last_name','providers.wallet')->where('user_wallet_histories.type','2')->where('user_wallet_histories.user_type','1')->where('user_wallet_histories.status','2')->orderBy('user_wallet_histories.id','DESC')->get();
        return view('admin.provider.decline',compact('withdraw'));
    }
    
    public function updateWithdrawStatus($id, $status)
    {
        $withdraw = UserWalletHistory::where('id',$id)->first();
        $withdraw->status = $status;
        $withdraw->update();
        if($status == '1')
        {
            $provider = Provider::where('id',$withdraw->user_id)->first();
            $provider->wallet = $provider->wallet-$withdraw->amount;
            $provider->update();
        }
        
        return redirect()->route('admin.provider.withdrawal')->with('success','Withdrawal Status Update Successfully');
    }
    
   public function getappname()
    {
        $app = AppSetting::first();
        
        return response()->json(['status' => '200', 'message' => 'appname', 'data' => $app]);
    } 
    
    
    
    
}