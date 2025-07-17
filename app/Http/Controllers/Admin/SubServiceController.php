<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SubService;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;
use Session;

class SubServiceController extends Controller
{
    /** Add Sub Service **/
    public function addSubService()
    {
        $service = Service::whereNull('deleted_at')->get();
        
        return view('admin.services.add-sub-service',compact('service'));
    }
    
    /** Insert Sub Service **/
    public function storeSubService(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $service = new SubService;
        $service->service_id = $request->service_id;
        $service->title = $request->title;
        
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);
        $service->image = $imageName;
        
        $service->currency_code = '₹';
        $service->price = $request->price;
        $service->time = $request->time;
        $service->description = $request->description;
        $service->save();
        
        return redirect()->route('admin.service.subServiceList')->with('success','Sub Service Add Successfully!');
    }
    
    /** View Sub Service **/
    public function subServiceList()
    {
        $subService = SubService::join('services','sub_services.service_id','=','services.id')->select('sub_services.*','services.title as service_name')->whereNull('sub_services.deleted_at')->get();
        
        return view('admin.services.sub-service-list', compact('subService'));
    }
    
    /** Update Sub Service Status **/
    public function changeSubServiceStatus(Request $request)
    {
        $service = SubService::find($request->id);
        $service->status = $request->status;
        $service->save();
  
        Session::flash('success', 'Sub Service status update successfully!');
        return response()->json(['success' => true, 'url' => '/blink/admin/service/subServiceList'], 200);
    }
    
    /** Edit Sub Service **/
    public function editSubService($id)
    {
        $service = Service::whereNull('deleted_at')->get();
        $subService = SubService::where('id',$id)->first();
        
        return view('admin.services.edit-sub-service',compact('service','subService'));
    }
    
    /** Update Sub Service **/
    public function updateSubService(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $subService = SubService::findOrFail($id);
        $subService->service_id = $request->service_id;
        $subService->title = $request->title;
        if($request->image != '')
        {
            $path = public_path().'/images/';
            if($subService->image != ''  && $subService->image != null){
                $file_old = $path.$subService->image;
                unlink($file_old);
            }
            
            $imageName = time().'.'.$request->image->extension();
            $request->image->move($path, $imageName);
            $subService->image = $imageName;
        }
        $subService->currency_code = '$';
        $subService->price = $request->price;
        $subService->time = $request->time;
        $subService->description = $request->description;
        $subService->update();
        
        return redirect()->route('admin.service.subServiceList')->with('success', 'Sub Service Update Successfully!');
    }
    
    /** Delete Sub Service **/
    public function deleteSubService(Request $request,$id)
    {
        $service = SubService::where('id',$id)->delete();
        
        return redirect()->route('admin.service.subServiceList')->with('success','Sub Service Delete Successfully!');
    }
}