<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DressCode;
use App\Http\Controllers\Controller;
use DB;
use Session;

class DressCodeController extends Controller
{
    /** Dress Code List **/
    public function index()
    {
        $dress = DressCode::all();
        
        return view('admin.dress.index',compact('dress'));
    }
    
    /** Dress Code Update Status **/
    public function updateStatus(Request $request)
    {
        $dress = DressCode::find($request->id);
        $dress->status = $request->status;
        $dress->save();
        
        if($request->status == '0')
        {
            Session::flash('success', 'Dress Code Activate successfully!');
        }
        else
        {
            Session::flash('success', 'Dress Code Inactivate successfully!');
        }
        return response()->json(['success' => true, 'url' => '/admin/dress'], 200);
    }
    
    /** Soft Delete Question **/
    /*public function delete(Request $request,$id)
    {
        $question = ConditionQuestion::where('id',$id)->delete();
        
        return redirect()->route('admin.question')->with('success','Question Delete Successfully!');
    }*/
    
    public function edit($id)
    {
        $dress = DressCode::where('id',$id)->first();
        
        return view('admin.dress.edit',compact('dress'));
    }
    
    /** Update Question **/
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        
        $question = DressCode::findOrFail($id);
        $question->title = $request->title;
        if($request->image != '')
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('dress'),$image);
            $question->image = $image;
        }
        $question->update();
        
        return redirect()->route('admin.dress')->with('success', 'Dress Code Update Successfully!');
    }
    
}