<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\comment;
use App\post;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = post::where("to_id",Auth::user()->uid)->orderBy('time', 'desc')->get();
        $new_count = post::where("to_id",Auth::user()->uid)->where('read',0)->get()->count();
        $feedbacks_seen = post::where('to_id',Auth::user()->uid)->update(['read' => 1]);
        // check comments on post (count)
        $commentsCount = array();
        foreach ($feedbacks as $fb) {
            $pid = $fb->pid;
            $countComments = comment::where("c_pid",$pid)->get()->count();
            array_push($commentsCount,$countComments);
        }
        return view('home')->with(['feedbacks' => $feedbacks,'new_count' => $new_count,'commentsCount' => $commentsCount]);
    }
}
