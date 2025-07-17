<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\Booking;
use App\Models\AppSetting;
use App\Models\SubService;
use App\Models\Service;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AdminController extends Controller
{
    /** Get Legal **/
    public function legal()
    {
        $legal = Policy::first();
        
        return view('admin.site.legal',compact('legal'));
    }
    
    /** Update Legal **/
    public function updateLegal(Request $request, $id)
    {
        $legal = Policy::findOrFail($id);
        $legal->title = $request->title;
        $legal->description = $request->editor1;
        $legal->update();
        
        return redirect()->route('admin.legal')->with('success', 'Legal Update successfully!');
    }
    
    /** Admin Commission **/
    public function commission()
    {
        $commission = AppSetting::first();
        
        return view('admin.site.commission',compact('commission'));
    }
    
    /** Update Commission **/
    public function updateCommission(Request $request, $id)
    {
        $commission = AppSetting::findOrFail($id);
        $commission->commission = $request->commission;
        $commission->update();
        
        return redirect()->route('admin.commission')->with('success','Commission Update Successfully');
    }
        
    /** View Booking History **/
    public function bookingHistory()
    {
        $booking = Booking::join('users','bookings.user_id','=','users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->select('bookings.*','users.first_name as user_first','users.last_name as user_last','users.mobile_number as mobile_no','services.title as service_name','sub_services.title as sub_title')->orderBy('bookings.id','DESC')->get();
        
        $currency = AppSetting::first();
        return view('admin.booking.index',compact('booking','currency'));
    }
    
    
    
    public function bookingdelete(Request $request,$id)
    {
        $user = Booking::where('id',$id)->delete();
        
        return redirect()->route('admin.bookingHistory')->with('success','Booking Delete Successfully!');
    }
    
    
    
    
    
    public function bookingDetail($id)
    {
        $currency = AppSetting::first();
        
        $booking = Booking::join('users','bookings.user_id','=','users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->select('bookings.*','users.first_name as user_first','users.last_name as user_last','services.title as service_name','sub_services.title as sub_title')->where('bookings.id',$id)->orderBy('bookings.id','DESC')->get()->first();
        
       // var_dump($booking);
        
     return view('admin.booking.bookdetail',compact('booking','currency'));
     
     
    }
    
    
    public function existingcanceelledbooking()
    
    {   
          $existing = Booking::where('status','CANCELLED')->get();
        
           $s = Service::get();
         
        return view('admin.booking.addnewbooking',compact('existing','s'));
    }
    
    
    
    
    
     
    public function getajaxdata(Request $request)
    
    {   $id = $request->bookid;
            
        $booking = Booking::join('users','bookings.user_id','=','users.id')->join('services','bookings.service_id','=','services.id')->join('sub_services','bookings.sub_service_id','=','sub_services.id')->select('bookings.*','users.first_name as user_first','users.last_name as user_last','services.title as service_name','sub_services.title as sub_title')->where('bookings.booking_id',$id)->orderBy('bookings.id','DESC')->get()->first();
        
          
        return response()->json(['status' => '200', 'message' => ' get Data', 'data' => $booking]);
    }
    
    
     public function servicesubservice(Request $request)
    
    {   
        

            $id = $request->servicedata;
            
        $services = SubService::where('service_id',$id)->get();
        
        
        foreach($services as $servicesdata)
        {
            ?>
            <option value="<?php echo $servicesdata->id ?>"> <?php echo $servicesdata->title ?></option>
            
            <?php
        }
        
        
        
        
        

        
    }
    
    public function servicesubbservice(Request $request)
    
    {   
        

            $id = $request->servicedata;
            
        $services = SubService::where('id',$id)->get()->first();
        
        echo $services->price;
        
        
      
        
        

        
    }
    
    
    
    
    
      
}