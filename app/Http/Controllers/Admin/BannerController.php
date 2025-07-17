<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use DB;
use Session;

class BannerController extends Controller
{
    /** Banner Edit **/
    public function edit()
    {
        $banner = Banner::where('id','1')->first();
        
        return view('admin.banner.edit',compact('banner'));
    }
    
    /** Update Banner **/
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        if($request->image != '')
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('banner'),$image);
            $banner->image = $image;
        }
        $banner->description = $request->description;
        $banner->update();
        
        return redirect()->route('admin.banner.edit')->with('success', 'Banner Update Successfully!');
    }
    
}