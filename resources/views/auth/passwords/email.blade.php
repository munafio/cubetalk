@extends('layouts.app')
@section('page_title') @lang('trans.resetPassword') @endsection
@section('content')
<div class="main_card" style="text-align: @lang('trans.align')">
    <div class="card-header" style="padding-top: 0;background-color: transparent;">@lang('trans.resetPassword')</div>

    <div class="card-body" style="padding-bottom: 0;">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" aria-label="@lang('trans.resetPassword')">
            @csrf

            <div class="form-group">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('trans.emailAddress')">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark">
                    @lang('trans.send_link')
                </button>
            </div>
        </form>
        <small class="form-text text-muted" style="border-top: 1px solid #eaeaea; padding-top: 10px;font-size: 74%;">@lang('trans.sen_link_MSG')</small>
    </div>
</div>
@endsection
