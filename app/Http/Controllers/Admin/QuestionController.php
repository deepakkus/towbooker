<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ConditionQuestion;
use App\Models\Service;
use App\Models\SubService;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use DB;
use Session;

class QuestionController extends Controller
{
    /** Question List **/
    public function index()
    {
        $question = ConditionQuestion::join('services','condition_questions.service_id','=','services.id')->join('sub_services','condition_questions.sub_service_id','=','sub_services.id')->select('condition_questions.*','services.title as service_name','sub_services.title as sub_service_name')->orderBy('id','DESC')->get();
        
        return view('admin.question.index',compact('question'));
    }
    
    /** Create Question **/
    public function create()
    {
        $service = Service::all();
        
        return view('admin.question.create',compact('service'));
    }
    
    public function getSubService(Request $request)
    {
         $serviceid=$request->service_id;
         
         $sub = SubService::where('service_id',$serviceid)->get();
         if($sub)
         {
            foreach($sub as $row)
            {
                echo'<option value='.$row["id"].'>'.$row["title"].'</option>';
            }
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'sub_service_id' => 'required',
            'question' => 'required',
            'answer1' => 'required',
            'answer2' => 'required',
        ]);
        
        $question = new ConditionQuestion;
        $question->service_id = $request->service_id;
        $question->sub_service_id = $request->sub_service_id;
        $question->question = $request->question;
        $question->answer1 = $request->answer1;
        $question->answer2 = $request->answer2;
        $question->answer3 = $request->answer3;
        $question->answer4 = $request->answer4;
        $question->save();
        
        return redirect()->route('admin.question')->with('success','Question Add Successfully!');
    }
    
    public function updateStatus(Request $request)
    {
        $question = ConditionQuestion::find($request->id);
        $question->status = $request->status;
        $question->save();
        
        if($request->status == '1')
        {
            Session::flash('success', 'Question Activate successfully!');
        }
        else
        {
            Session::flash('success', 'Question Inactivate successfully!');
        }
        return response()->json(['success' => true, 'url' => '/admin/question'], 200);
    }
    
    /** Soft Delete Question **/
    public function delete(Request $request,$id)
    {
        $question = ConditionQuestion::where('id',$id)->delete();
        
        return redirect()->route('admin.question')->with('success','Question Delete Successfully!');
    }
    
    public function edit(Request $request)
    {
        $question = ConditionQuestion::where('id',$request->id)->first();
        $service = Service::all();
        $sub = SubService::where('service_id',$question->service_id)->get();
        
        return view('admin.question.edit',compact('question','service','sub'));
    }
    
    /** Update Question **/
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required',
            'sub_service_id' => 'required',
            'question' => 'required',
            'answer1' => 'required',
            'answer2' => 'required',
        ]);
        
        $question = ConditionQuestion::findOrFail($id);
        $question->service_id = $request->service_id;
        $question->sub_service_id = $request->sub_service_id;
        $question->question = $request->question;
        $question->answer1 = $request->answer1;
        $question->answer2 = $request->answer2;
        $question->answer3 = $request->answer3;
        $question->answer4 = $request->answer4;
        $question->update();
        
        return redirect()->route('admin.question')->with('success', 'Question Update Successfully!');
    }
    
}