@extends('layouts.app')
@section("page_title","Home")
@section('content')
@include('layouts.userCard')
<div class="profile_links">
	<ul>
		<li><a href="{{ route('profile',Auth::user()->username) }}">@lang('trans.public')</a></li>
		<li><a href="{{ route('home') }}" style='border-bottom: 3px solid #3296f3;'>
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
	</ul>
</div>
@include('layouts.postCard')
@endsection
