<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ReviewController extends Controller
{
    /** Dress Code List **/
    public function index()
    {
        $review = Booking::join('users','bookings.user_id','=','users.id')->select('bookings.*','users.first_name','users.last_name')->get();
        
        return view('admin.review.index',compact('review'));
    }
    
}