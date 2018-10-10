@extends('layouts.app')
@section('page_title') @lang('trans.register') @endsection
@section('content')
<div class="main_card" style="text-align: @lang('trans.align')">
  <h4>@lang('trans.create_account')</h4>
<form method="POST" action="{{ route('register') }}" aria-label="@lang('trans.register')">
    @csrf
    <div class="form-group">
      <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"  autofocus  placeholder="@lang('trans.fullname')">
      @if ($errors->has('name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
  </div>
  <label style="display: block;" for="un">@lang('trans.your_fbURL')</label>
  <div class="input-group mb-3" style="margin-bottom: 0!important;direction: @lang('trans.dirV');">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon3">{{ config("app.urlInView") }}</span>
    </div>
    <input type="text" id="un" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" aria-describedby="basic-addon3" placeholder="@lang('trans.username')">
    @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
    @endif
  </div>
  <small style="margin-bottom: 1rem!important;" id="unHelp" class="form-text text-muted">@lang('trans.usernameOnlyMSG')</small>
  <div class="form-group">
    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="@lang('trans.emailAddress')">
    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
      <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  placeholder="@lang('trans.password')">
      @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
      <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('trans.confirm_password')">
  </div>
<div class="custom-control custom-checkbox mr-sm-2" style="padding-left: 0;">
  <div class="form-group">
    <div class="form-check">
      <input class="custom-control-input{{ $errors->has('terms') ? ' is-invalid' : '' }}" type="checkbox" id="agree_signup" name="terms" checked="checked">
      <label style="@if (App::isLocale('ar')) padding:0px 15px; @endif" class="custom-control-label" for="agree_signup">
         @lang('trans.ihaveRead_msg') <a href="{{ url("terms") }}">@lang('trans.terms_of_service')</a> @lang('trans.and') <a href="{{ url("terms#privacy") }}">@lang('trans.privacy_policy')</a>.
      </label>
      @if ($errors->has('terms'))
        <span class="invalid-feedback" role="alert">{{ $errors->first('terms') }}</span>
      @endif
      
    </div>
  </div>
</div>
   <button type="submit" class="btn btn-dark">@lang('trans.register')</button>
</form>
   <hr>
  @lang('trans.alreadyA_member') <a href="login">@lang('trans.login')</a> @lang('trans.now').
</div>

@endsection