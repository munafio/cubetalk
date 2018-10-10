<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\comment;
use App\User;
use App\post;
use Auth;
use Lang;


class commentsController extends Controller
{
    public function comment(Request $request){
    	$cid = rand(9,999999999)+time()+rand(4,99);
    	$c_pid = $request['pid'];
    	if (Auth::user()) {
    		$c_from = Auth::user()->uid;
    		$myUsername = Auth::user()->username;
    		$myAvatar = 'storage/avatar/'.Auth::user()->avatar;
    	}elseif (Auth::guest()) {
    		$c_from = 0;
    		$myUsername = '';
    		$myAvatar = 'imgs/avatar.png';
    	}
    	$comment = $request['comment'];
    	$cTime = $request['cTime'];
    	$path = $request['path'];

    	// send to DataBase
    	$sendComment = new comment();
    	$sendComment->cid = $cid;
    	$sendComment->c_pid = $c_pid;
    	$sendComment->c_from = $c_from;
    	$sendComment->comment = $comment;
    	$sendComment->time = $cTime;
    	$sendComment->save();

    	// check to hide or show comment username
    	$getPost_uids = post::where('pid',$c_pid)->get();
    	foreach ($getPost_uids as $getPost_uid) {
    		$post_uid = $getPost_uid->to_id;
    	}
    	if ($post_uid == $c_from) {
			$uname = '<a href="'.$path.'/'.$myUsername.'">'.$myUsername.'</a> ';
		}else{
			$uname ='';
		}

		// echo the final result
		echo '
		<div class="comment-item">
			<div>
				<img src="'.$path.'/'.$myAvatar.'">
			</div>
			<p>
				'.$uname.'
				'.$comment.'
				<span class="timeNow">'.Lang::get('trans.justNow').'</span>
			</p>
		</div>
		';
    }
    
    public function showComments(Request $request){
    	// $request['pid']
    	$getPosts = post::where('pid',$request['pid'])->get();
    	foreach ($getPosts as $post) {
    		$getComments = comment::where('c_pid',$request['pid'])->get();
	    	foreach ($getComments as $comment) {
	    		$getUser = User::where('uid',$comment->c_from)->get();
	    		foreach ($getUser as $user) {
	    			if ($post->to_id == $comment->c_from) {
						$uname = '<a href="'.$request['path'].'/'.$user->username.'">'.$user->username.'</a> ';
						$uavatar = $user->avatar;
					}else{
						$uname = '';
						$uavatar = 'avatar.png';
					}
                    if (!Auth::guest()) {
                        if ($comment->c_from == Auth::user()->uid) {
                            $commentDel = '<span class="fas fa-trash-alt delete-comment" data-toggle="modal" data-target="#delModal_modal" data-cdelete="'.$comment->cid.'"></span>';
                        }else{
                            $commentDel = '';
                        }
                    }else{
                        $commentDel = '';
                    }
		    		echo '
					<div class="comment-item" data-comment="'.$comment->cid.'">
						<div style="background-image:url(\''.$request['path'].'/storage/avatar/'.$uavatar.'\');">
						</div>
						<p>
							'.$uname.'
							'.$comment->comment.'
							<span class="cTimeNow" style="margin-bottom:5px;">'.$comment->time.'</span>
							'.$commentDel.'
						</p>
					</div>
					';
	    		}
	    	}
    	}
    }
    public function deleteComment(Request $request){
    	$checkID = comment::where('cid',$request['cid'])->get()->count();
    	if ($checkID > 0) {
    		$allowed = comment::where('cid',$request['cid'])->get();
    		foreach ($allowed as $getAllowed) {
    			$c_from = $getAllowed->c_from;
    		}
    		if ($c_from == Auth::user()->uid) {
    			$deleteC = comment::where('cid',$request['cid'])->delete();
    			return "done";
    		}else{
    			return Lang::get('trans.delComm_notAllowed');
    		}
    	}else{
    		return Lang::get('trans.err_somethingWrong');
    	}
    }
}
    	