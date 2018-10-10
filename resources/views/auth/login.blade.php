@extends('layouts.app')
@section('page_title') @lang('trans.login') @endsection
@section('content')
<div class="main_card" style="text-align: @lang('trans.align')">
  <h4>@lang('trans.login') @lang('trans.now')!</h4>
<form method="POST" action="{{ route('login') }}" aria-label="@lang('trans.login')">
@csrf
<div class="form-group">
    <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" autofocus placeholder="@lang('trans.username')">
     @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group">
    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang('trans.password')">
    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
  </div>
    <div class="custom-control custom-checkbox mr-sm-2">
        <div class="form-group">
            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label style="@if (App::isLocale('ar')) padding:0px 15px; @endif" class="custom-control-label" for="remember">@lang('trans.rememberMe')</label>
        </div>
    </div>
  <button type="submit" class="btn btn-dark">@lang('trans.login')</button>
  <a href="{{ route('password.request') }}">@lang('trans.resetPassword')</a>
  </form>
  <hr>
  @lang('trans.dont_have_an_account') <a href="{{ route('register') }}">@lang('trans.create_account')</a> @lang('trans.now').
</div>

@endsection
