<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AppSetting;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AppSettingController extends Controller
{
    public function appsetting()
    {
        $app = AppSetting::where('id','1')->first();
        return view('admin.app.index',compact('app'));
    }
    
    public function updateAppSetting(Request $request,$id)
    {
        $request->validate([
            'app_name' => 'required',
            'app_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_symbol' => 'required',
            'currency_code' => 'required',
        ]);
        
        $app = AppSetting::findOrFail($id);
        $app->app_name = $request->app_name;
        if($request->app_icon != '')
        {
            $imageName = time().'.'.$request->app_icon->extension();  
            $request->app_icon->move(public_path('app'), $imageName);
            $app->app_icon = url('public/app/'.$imageName);
        }
        $app->currency_symbol = $request->currency_symbol;
        $app->currency_code = $request->currency_code;
        $app->update();
        
        if($app)
        {
            $service = DB::table('services')->update(array('currency_code' => $request['currency_symbol']));
        }
        if($app)
        {
            $sub = DB::table('sub_services')->update(array('currency_code' => $request['currency_symbol']));
        }
        
        return redirect()->route('admin.appsetting')->with('success','App Setting Update Successfully');
    }
    
}