<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\Service;
use App\Models\SubService;
use App\Models\VehicleType;
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

class ServiceController extends Controller
{
    /* Get Service */
    public function getService()
    {
        $service = Service::where('status','1')->get();

        return response()->json(['message' => 'Success','data' => $service], 200); 
    }
    
    
    // get vehicle
    
      public function getvehicle()
    {
        $vehicle = VehicleType::get();

        return response()->json(['message' => 'Success','data' => $vehicle], 200); 
    }
    
    
    
    
    
    /* Get Sub Service */
    public function getSubService(Request $request)
    {
        $id = $request->id;
        $subservice = SubService::where('service_id',$id)->get();
        if($subservice != '')
        {
            return response()->json(['status' => '200', 'message' => 'SubService','data' => $subservice]);
        }
        else
        {
            return response()->json(['status' => '200', 'message' => 'SubService Not Found','data' => '']);
        }
    }
    
    /* Get Condition Question */
    public function getConditionQuestion(Request $request)
    {
        $id = $request->id;
        $condtionQuestion = ConditionQuestion::where('sub_service_id',$id)->get();
        return response()->json(['status' => '200', 'message' => 'Condition Question','data' => $condtionQuestion]);
        
    }
    
    /* Service Details */
    public function getServiceDetails(Request $request)
    {
        $id = $request->id;
        $service = Service::where('id',$id)->first();
        return response()->json(['message' => 'Success','data' => $service], 200);
    }
}
