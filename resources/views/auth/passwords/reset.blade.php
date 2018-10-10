@extends('layouts.app')
@section('page_title') @lang('trans.resetPassword') @endsection
@section('content')
<div class="main_card" style="text-align: @lang('trans.align')">
    <div class="card-header" style="padding-top: 0;background-color: transparent;">@lang('trans.resetPassword')</div>

    <div class="card-body" style="padding-bottom: 0;">
        <form method="POST" action="{{ route('password.request') }}" aria-label="@lang('trans.resetPassword')">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="@lang('trans.emailAddress')" autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
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

            <div class="form-group">
                <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('trans.confirm_password')">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-dark">
                    @lang('trans.resetPassword')
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
