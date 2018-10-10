@extends('layouts.app')
@section('content')
@section("page_title","Settings")
@foreach($user_info as $u)
<div class="main_card" @if (App::isLocale('ar')) style="text-align: right;" @endif>

<ul class="nav nav-tabs" @if (App::isLocale('ar')) style="padding-right:0;" @endif>
  <li class="nav-item">
    <a class="nav-link active" id="General_link" data-toggle="tab" href="#General">@lang("trans.general")</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="Change_password_link" data-toggle="tab" href="#Change_password">@lang("trans.password")</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="delete_account_link" data-toggle="tab" href="#delete_account">@lang("trans.delete_account")</a>
  </li>
</ul>
<br>
<div class="tab-content">
	{{-- =======================General section========================== --}}
<div id="General" class="tab-pane fade-in active">
@if(session()->has('general_msg'))
    <div class="alert alert-success">
        {{ session()->get('general_msg') }}
    </div>
    <script type="text/javascript">
    	$(".tab-pane").removeClass("fade-in active");
    	$("#General").addClass("fade-in active");
    	$(".nav-link").removeClass("active");
    	$("#General_link").addClass("active");
    </script>
@endif
<form method="POST" action="{{ route('general_update') }}" enctype="multipart/form-data">
@csrf
	<div style="display: inline-flex;">
    <div class="profile-avatar" id="settings_img_elm" style="margin: 10px; margin-top: 0; margin-bottom: 0;border-color: #fff; text-align: center;background-image: url('{{ url("/storage/avatar/".Auth::user()->avatar) }}');">
	</div>
	<p style="color: #a7aab5; font-size: 13px;padding: 25px 10px 25px 10px; margin: 0;">@lang("trans.preview")<br>@lang("trans.maxSize")</p>
	</div>
  <p style="border-bottom: 1px solid #dfe2e6;margin: 0; margin-top: 12px; margin-bottom: 12px;">
  	<input type="file" name="avatar" style="display: none;" id="settings_img">
  	<label for="settings_img" class="btn btn-success">@lang("trans.selectImage")</label>
  	@if ($errors->has('avatar'))
        <span class="invalid-feedback" role="alert" style="display: block;">
            <strong>{{ $errors->first('avatar') }}</strong>
        </span>
  @endif
  </p>
  <div class="form-group">
  	<label for="fullname">@lang("trans.fullname")</label>
    <input type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" placeholder="@lang("trans.fullname")" value="{{ $u->name }}">
    @if ($errors->has('fullname'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('fullname') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
  	<label for="username">@lang("trans.username") (@lang("trans.unchangeable"))</label>
    <label class="form-control" name="username" >{{ "@".$u->username }}</label>
  </div>
  <div class="form-group">
  	<label for="email">@lang("trans.emailAddress")</label>
    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="@lang("trans.emailAddress")" value="{{ $u->email }}">
    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
  </div>
  <button type="submit" class="btn btn-dark">@lang("trans.save_changes")</button>
  </form>
</div>
	{{-- =======================Change password section========================== --}}
<div id="Change_password" class="tab-pane">
@if($errors->has('cpassword') || $errors->has('password') || session()->has('password_msg') || session()->has('cpd_error'))
	@if(session()->has('password_msg'))
		<div class="alert alert-success">
	        {{ session()->get('password_msg') }}
	    </div>
	@endif
    <script type="text/javascript">
    	$(".tab-pane").removeClass("fade-in active");
    	$("#Change_password").addClass("fade-in active");
    	$(".nav-link").removeClass("active");
    	$("#Change_password_link").addClass("active");
    </script>
@endif
<form method="POST" action="{{ route('password_update') }}" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <input type="password" class="form-control{{ $errors->has('cpassword') || session()->has('cpd_error') ? ' is-invalid' : '' }}" name="cpassword" placeholder="@lang("trans.current_password")">
    @if ($errors->has('cpassword'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cpassword') }}</strong>
        </span>
    @endif
    @if (session()->has('cpd_error'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ session()->get('cpd_error') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang("trans.new_password")">
    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
    <input type="password" class="form-control" name="password_confirmation" placeholder="@lang("trans.confirm_password")">
  </div>
  <button type="submit" class="btn btn-dark">@lang("trans.save_changes")</button>
 </form>
</div>
	{{-- =======================Delete Account========================== --}}
<div id="delete_account" class="tab-pane">
@if(session()->has('delete_account'))
    <script type="text/javascript">
    	$(".tab-pane").removeClass("fade-in active");
    	$("#delete_account").addClass("fade-in active");
    	$(".nav-link").removeClass("active");
    	$("#delete_account_link").addClass("active");
    </script>
@endif
<form method="POST" action="{{ route('delete_account') }}" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <input type="password" class="form-control{{ session()->has('delete_account') ? ' is-invalid' : '' }}" name="da_password" placeholder="@lang("trans.current_password")">
    @if (session()->has('delete_account'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ session()->get('delete_account') }}</strong>
        </span>
    @endif
  </div>
  <small style="margin-bottom: 1rem!important;" class="form-text text-muted">@lang("trans.delAcc_notice")</small>
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_account_modal">@lang("trans.delete_account")</button>
 {{-- =========== Delete confirm modal ========== --}}
<div class="modal fade" id="delete_account_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 30px;">
      <div class="modal-body" style="font-size: 12px; color: #7a7a7a;">
       <p style="font-size: 15px; color: #000; margin-bottom: 5px;">@lang("trans.delAcc_m_MSG1")</p>
       @lang("trans.delAcc_m_MSG2")
      </div>
      <div class="modal-footer" style="justify-content: center;">
        <button type="button" class="btn btn-light" data-dismiss="modal">@lang("trans.cancel")</button>
        <button type="submit" class="btn btn-danger">@lang("trans.yes"), @lang("trans.delete")</button>
      </div>
    </div>
  </div>
</div>
</form>
 {{-- =========== End Delete confirm modal ========== --}}
</div>
</div>
</div>

@endforeach
@endsection
