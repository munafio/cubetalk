<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use Auth;
use Lang;

class postsController extends Controller
{
    public function send_feedback(Request $request){
    	$this->validate($request,[
    		'feedback_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
    		'feedback_content' => 'required|max:500'
    	]);
    	$pid = rand(9,999999999)+time();
    	if (Auth::user()) {
    		$from_id = Auth::user()->uid;
    	}elseif (Auth::guest()) {
    		$from_id = 0;
    	}
    	$to_id = $request['hidden2'];
    	$feedback = $request['feedback_content'];
    	$image = $request->file('feedback_image');
    	$time = $request['hidden'];
	    if ($request->hasFile('feedback_image')) {
    		$img_ext = $image->getClientOriginalExtension();
			$img_name = rand(9,9999999)+time()+rand(0,55555).".".$img_ext;
    		$img_new = $image->storeAs("fbImgs",$img_name);
    	}else{
    		$img_name = "";
    	}
    	$post = new post();
    	$post->pid = $pid;
    	$post->from_id = $from_id;
    	$post->to_id = $to_id;
    	$post->feedback = $feedback;
    	$post->image = $img_name;
    	$post->time = $time;
    	$post->save();
    	return redirect()->back()->with('feedback_sent',Lang::get('trans.fb_sent'));
    }
    public function postPrivacy(Request $request){
    	$pid_var = $request['pid'];
    	$pid_ex = explode("_", $pid_var);
    	$pid = @$pid_ex[1];
		if ($request['status'] == "true") {
			$updatePrivacy = post::where('pid',$pid)->update(['privacy' => 1]);
		}else{
			$updatePrivacy = post::where('pid',$pid)->update(['privacy' => 0]);
		}
		return $pid;
    }
    public function deletePost(Request $request){
    	$checkID = post::where('pid',$request['pid'])->get()->count();
    	if ($checkID > 0) {
    		$allowed = post::where('pid',$request['pid'])->get();
    		foreach ($allowed as $getAllowed) {
    			$to_id = $getAllowed->to_id;
    			$from_id = $getAllowed->from_id;
    		}
    		if ($to_id == Auth::user()->uid || $from_id == Auth::user()->uid) {
    			$deleteFB = post::where('pid',$request['pid'])->delete();
    			return "done";
    		}else{
    			return Lang::get('trans.delPost_notAllowed');
    		}
    	}else{
    		return Lang::get('trans.err_somethingWrong');
    	}
    }
}
