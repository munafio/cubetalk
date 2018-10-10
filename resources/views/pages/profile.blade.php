@extends('layouts.app')
@section('content')
@if(!json_decode($user_info))
@section("page_title","Oops!")
<div class="main_card" style="text-align: center;">
	<h3><span style="color: #c6c6c6;" class="fas fa-exclamation-circle"></span> Oops!</h3>
	<p style="margin: 0;">@lang('trans.profileErr_MSG')</p>
</div>
@else
@foreach($user_info as $u)
@section("page_title",$u->name)
<div class="main_card" style="text-align:center;background:#353d48;margin-top: -1px;border: none;">
<div class="profile-header">
	<div style="position: relative;">
		@auth
		@if(Auth::user()->username == $u->username)
		<a href="{{ url($u->username."/settings") }}" class="profile-edit"><span class="fas fa-user-edit"></span></a>
		@endif
		@endauth
	<div class="profile-avatar" style="background-image: url('{{ url("/storage/avatar/".$u->avatar) }}');">
	</div>
	</div>
	<div class="profile-userInfo" @if(App::isLocale('ar')) style="direction: ltr" @endif>
		<p><a href="{{ url($u->username) }}">{{ $u->name }}</a>
		@if($u->verify == 1) <span class="verify-badge" style="background: url({{ asset('imgs/verify.png') }});"></span> @endif
		</p>
		<span>{{ "@".$u->username }} | <span class="profile-badge"><i class="fas fa-envelope"></i> {{ $feedbacks_count }}</span></span>
	</div>
</div>
</div>
<div class="profile_links">
	<ul>
		<li><a href="{{ route('profile',$u->username) }}" style='border-bottom: 3px solid #3296f3;'>@lang('trans.public')</a></li>
		@if(Auth::user())
		@if(Auth::user()->username == $u->username)
		<li><a href="{{ route('home') }}">
			@lang('trans.received') 
		@if($new_count > 0)
			@if($new_count > 99)
				<span class="new_notification">+99</span>
			@else
				<span class="new_notification">{{ $new_count }}</span> 
			@endif
		@endif
		</a>
		</li>
		<li><a href="{{ route('sent',Auth::user()->username) }}">@lang('trans.sent')</a></li>
		@endif
		@endif
	</ul>
</div>
@section('send_feedback')
<div class="send_feedback_card">
@if(session()->has('feedback_sent'))
    <div style="margin-bottom:0;@if(App::isLocale('ar')) text-align: right; @endif" class="alert alert-success">
        {{ session()->get('feedback_sent') }}
    </div><br>
@else
<form method="POST" action="{{ route('send_feedback') }}" enctype="multipart/form-data" id="send_feedback_form">
@csrf
<input type="hidden" name="hidden" id="feedback_hidden">
<input type="hidden" name="hidden2" id="feedback_hidden2" value="{{ $u->uid }}">
<textarea @if(App::isLocale('ar')) style="direction: inherit;" @endif dir="auto" name="feedback_content" class="send_feedback_field" maxlength="500" placeholder="@lang('trans.postPlaceholder_MSG')"></textarea>
<div id="send_feedback_footer" @if(App::isLocale('ar')) style="text-align: right;" @endif>
@if ($errors->has('feedback_content'))
<p style="margin: 0;margin-bottom: 5px;">
	<span class="invalid-feedback" role="alert">
	    <strong>{{ $errors->first('feedback_content') }}</strong>
	</span>
</p>
@elseif ($errors->has('feedback_image'))
<p style="margin: 0;margin-bottom: 5px;">
	<span class="invalid-feedback" role="alert">
	    <strong>{{ $errors->first('feedback_image') }}</strong>
	</span>
</p>
@endif
<input type="file" name="feedback_image" style="display: none;" id="feedback_hFile">
<label class="send_feedback_btn" for="feedback_hFile"><span class="fas fa-camera"></span></label>
<input type="submit" class="send_feedback_btn" id="send_feedback_now" value="@lang('trans.send') @lang('trans.now')">
<div class="send_feedback_image" id="sfb_image_preview">
	<span class="fas fa-times" id="sfb_image_preview_x"></span>
</div>
</div>
</form>
@endif
</div>
@endsection
@if(Auth::guest())
@yield('send_feedback')
@elseif($u->username != Auth::user()->username)
@yield('send_feedback')
@endif
@include('layouts.postCard')
@endforeach
@endif
@endsection
