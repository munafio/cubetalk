<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use App\comment;
use App\User;
use App\post;
use View;
use Lang;

class usersController extends Controller
{
    private $u;

    public function __construct(){
        $this->u = new User();
    }
    public function search(Request $request){
        $search_input = $request["input"];
        $path = $request["path"];
        $users = User::where("name","like","%$search_input%")->orWhere("username","like","%$search_input%")->get();
        
        if ($users->isEmpty()) {
            return "<p style='text-align: center;width: 100%;color: gray;font-size: 12px;margin: 3px'>".Lang::get('trans.nothingToShow')."</p>";
        }else{
            foreach ($users as $user) {
                if ($user->verify == 1) {
                    $ifVerify = '<span class="verify-badge" style="width: 14px; height: 14px; background:  url(\''.$path.'/imgs/verify.png\') no-repeat; background-size: cover; margin: 0px 2px;"></span>';
                }else{
                    $ifVerify = '';
                }
                if($user->avatar == "avatar.png"){
                    $avatar_path = '/imgs/avatar.png';
                }else{
                    $avatar_path = '/storage/avatar/'.$user->avatar;
                }
                echo '<div class="navbar-search-item">
                    <a href="'.$path.'/'.$user->username.'">
                        <div>
                            <div style="background-image:url(\''.$path.$avatar_path.'\');">
                            </div>
                            <p>
                                '.$user->name.$ifVerify.'<br>
                                <span>@'.$user->username.'</span>
                            </p>
                        </div>
                    </a>
                </div>';
            }
        }
    }
    public function profile($username){
        $user_info = User::where("username",$username)->get();
        foreach ($user_info as $uinfo) {
            $user_id = $uinfo->uid;
        }
        if (isset($user_id)) {
            $feedbacks = post::where("to_id",$user_id)->where("privacy",1)->orderBy('time', 'desc')->get();
            $feedbacks_count = post::where("to_id",$user_id)->get()->count();
            $new_count = post::where("to_id",$user_id)->where('read',0)->get()->count();
            // check comments on post (count)
            $commentsCount = array();
            foreach ($feedbacks as $fb) {
                $pid = $fb->pid;
                $countComments = comment::where("c_pid",$pid)->get()->count();
                array_push($commentsCount,$countComments);
            }
            return view("pages.profile")->with(["user_info" => $user_info,"feedbacks" => $feedbacks,'feedbacks_count' => $feedbacks_count,'new_count' => $new_count,'commentsCount' => $commentsCount]);
        }else{
            return view("pages.profile")->with(["user_info" => $user_info]);
        }
    }
    public function settings($username){
        $user_info = User::where("username",$username)->get();
        if (Auth::user()->username == $username) {
            return view("pages.settings")->with("user_info",$user_info);
        }else{
            return redirect()->back();
        }
        
    }
    public function s_general(Request $request){
        $this->validate($request,[
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'fullname' => 'required',
            'email' => 'required|email'
        ]);
        if ($request['fullname'] == Auth::user()->name && $request['email'] == Auth::user()->email && !$request->hasFile('avatar')) {
            return redirect()->back()->with('general_msg', Lang::get('trans.noChanges_MSG'));
        }else{
            $avatar = $request->file('avatar');
            if ($request->hasFile('avatar')) {
                $avatar_ext = $avatar->getClientOriginalExtension();
                $avatar_name = rand(9,999999999)+time().".".$avatar_ext;
                $avatar_new = $avatar->storeAs("avatar",$avatar_name);
            }else{
                $avatar_name = Auth::user()->avatar;
            }
            $update_general = User::where('uid',Auth::user()->uid)->update(['name' => $request['fullname'],'email' => $request['email'],'avatar' => $avatar_name]);
            return redirect()->back()->with('general_msg', Lang::get('trans.changes_saved'));
        }
        
    }
    public function s_password(Request $request){
        $this->validate($request,[
            'cpassword' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if (Hash::check($request['cpassword'], Auth::user()->password)){
            $password_update = User::where('uid', Auth::user()->uid)->update(['password' => Hash::make($request['password'])]);
            return redirect()->back()->with('password_msg', Lang::get('trans.password_changed'));
        }else{
            return redirect()->back()->with('cpd_error', Lang::get('trans.current_pwd_incorrect'));
        }
        
    }
    public function delete_account(Request $request){
        if (Hash::check($request['da_password'], Auth::user()->password)){
            $delete_account = User::where('uid',Auth::user()->uid)->delete();
            return redirect()->back();
        }else{
            return redirect()->back()->with('delete_account', Lang::get('trans.current_pwd_incorrect'));
        }
    }
    public function sentPage($name){
        if ($name != Auth::user()->username) {
            return redirect()->back();
        }else{
            $sent_toId=array();
            $feedbacks = post::where("from_id",Auth::user()->uid)->orderBy('time', 'desc')->get();
            $new_count = post::where("to_id",Auth::user()->uid)->where('read',0)->get()->count();
            foreach ($feedbacks as $fb) {
                $toId = $fb->to_id;
                $getToIds = User::where("uid",$toId)->get();
                foreach ($getToIds as $getToId) {
                    array_push($sent_toId,$getToId->username);
                }
            }
            // check comments on post (count)
            $commentsCount = array();
            foreach ($feedbacks as $fb) {
                $pid = $fb->pid;
                $countComments = comment::where("c_pid",$pid)->get()->count();
                array_push($commentsCount,$countComments);
            }
            return view("pages.sent")->with(['feedbacks' => $feedbacks,'sent_toId' => $sent_toId,'commentsCount' => $commentsCount,'new_count' => $new_count]);
        }
    }
}
