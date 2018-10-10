@extends('layouts.app')
@section('page_title') @lang('trans.mainTitle') @endsection
@section('content')

<div class="welcome_card">
    <h1><div class="welcome-brand-img"></div></h1>
    <p><strong>@lang('trans.mainTitle')</strong></p>
    <p>@lang('trans.join_us') @lang('trans.now')!</p>
    <p>
        <a href="{{ route('register') }}" class="register-btn">@lang('trans.register')</a>
        <a href="{{ route('login') }}" class="login-btn">@lang('trans.login')</a>
    </p>
    <h4 style="margin: auto; margin-top: 2rem; padding-top: 1rem; max-width: fit-content; border-top: 1px solid #e6e7ea;">@lang('trans.welcome_find_title')</h4>
    <ul style="text-align: @lang('trans.align')">
        <li><span class="fas fa-link"></span> @lang('trans.welcome_find_item1')
            <p style="font-size: 12px; color: #adadad;">@lang('trans.welcome_find_item1P')</p>
        </li>
        <li><span class="fas fa-share-alt"></span> @lang('trans.welcome_find_item2')
            <p style="font-size: 12px; color: #adadad;">@lang('trans.welcome_find_item2P')</p>
        </li>
        <li><span class="fas fa-users"></span> @lang('trans.welcome_find_item3')
            <p style="font-size: 12px; color: #adadad;">@lang('trans.welcome_find_item3P')</p>
        </li>
        <li><span class="fas fa-globe-americas"></span> @lang('trans.welcome_find_item4')
            <p style="font-size: 12px; color: #adadad;">@lang('trans.welcome_find_item4P')</p>
        </li>
    </ul>
</div>

@endsection