<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\SubService;
use App\Models\Booking;
use App\Models\AppSetting;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ServicesImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ServiceController extends Controller
{
    /** Add Service **/
    public function addService()
    {
        return view('admin.services.add-service');
    }
    
    /** Insert Service **/
    public function storeService(Request $request)
    {
        $currency = AppSetting::where('id','1')->first();
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $service = new Service;
        $service->title = $request->title;
        if($request->image != '')
        {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $service->image = $imageName;  
        }
        
        $service->currency_code = $currency->currency_symbol;
        $service->time = $request->time;
        $service->description = $request->description;
        $service->save();
        
        return redirect()->route('admin.service.serviceList')->with('success','Service Add Successfully!');
    }
    
    /** Update Service Status **/
    public function changeServiceStatus(Request $request)
    {
        $service = Service::find($request->id);
        $service->status = $request->status;
        $service->save();
  
        Session::flash('success', 'Service status update successfully!');
        return response()->json(['success' => true, 'url' => '/admin/service/serviceList'], 200);
    }
    
    
    
    
    
     public function statusupdatestore(Request $request)
    {
        echo( $request->status);
        
        $statusupdate = Booking::find($request->id);
        $statusupdate->status = $request->status;
        $statusupdate->save();
  
        return redirect()->back()->with('success','Status Updated Successfully!');
    }
    
    
    
    
    
    /** View Service List **/
    public function serviceList()
    {
        $service = Service::whereNull('deleted_at')->get();
        
        return view('admin.services.service-list', compact('service'));
    }
    
    /** Edit Service **/
    public function editService($id)
    {
        $service = Service::where('id',$id)->first();
        
        return view('admin.services.edit-service',compact('service'));
    }
    
    /** Update Service **/
    public function updateService(Request $request, $id)
    {
        $currency = AppSetting::where('id','1')->first();
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $service = Service::findOrFail($id);
        $service->title = $request->title;
        if($request->image != '')
        {
            $path = public_path().'/images/';
            if($service->image != ''  && $service->image != null){
                $file_old = $path.$service->image;
                unlink($file_old);
            }
            
            $imageName = time().'.'.$request->image->extension();
            $request->image->move($path, $imageName);
            $service->image = $imageName;
        }
        $service->currency_code = $currency->currency_symbol;
        $service->price = $request->price;
        $service->time = $request->time;
        $service->description = $request->description;
        $service->update();
        
        return redirect()->route('admin.service.serviceList')->with('success', 'Service Update Successfully!');
    }
    
    /** Delete Service **/
    public function deleteService(Request $request,$id)
    {
        $service = Service::where('id',$id)->delete();
        
        return redirect()->route('admin.service.serviceList')->with('success','Service Delete Successfully!');
    }
    
    public function bulkServiceImport()
    {
       return view('admin.services.bulk-import');
    }
    
    public function bulkServiceStore(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        
        Excel::import(new ServicesImport, $request->file('file')->store('public/images'));
        return redirect()->route('admin.service.serviceList')->with('success', 'Bulk Service Insert Successfully!');
    }
    
    
    
    
  
    
    
    
    
    
    
}