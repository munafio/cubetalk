<div class="main_card" style="text-align:center;background:#353d48;margin-top: -1px;border: none;">
<div class="profile-header" style="display: inline-flex;">
	<div style="position: relative;">
		@auth
		@if(Auth::user()->username == Auth::user()->username)
		<a href="{{ url(Auth::user()->username."/settings") }}" style="font-size: 12px" class="profile-edit"><span class="fas fa-user-edit"></span></a>
		@endif
		@endauth
	<div class="profile-avatar" style="width: 60px;height:60px;background-image: url('{{ url("/storage/avatar/".Auth::user()->avatar) }}');">
	</div>
	</div>
	<div class="profile-userInfo" style="margin: 0 10px;">
		<p><a href="{{ url(Auth::user()->username) }}">{{ Auth::user()->name }}</a>
      @if(Auth::user()->verify == 1) <span class="verify-badge" style="background: url({{ asset('imgs/verify.png') }});"></span> @endif
    </p>
		<p style="margin-top: .35rem;cursor: pointer;" class="profile_url" data-toggle="modal" data-target="#share_modal">{{ config("app.urlInView") }}{{ Auth::user()->username }}</p>
	</div>
</div>
</div>
{{-- ================= Share link modal ================= --}}
<div class="modal fade" id="share_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 30px;">
      <div class="modal-body" style="font-size: 12px; color: #7a7a7a;">
      	<span class="fas fa-times" style="position: absolute; font-size: 16px; cursor: pointer;" data-dismiss="modal"></span>
       <p style="text-align: center;margin-bottom: .55rem;">
       		<input type="text" id="shareUrl-copy-field" value="http://{{ config("app.urlInView") }}{{ Auth::user()->username }}" readonly>
       		<button id="shareUrl-copy-btn" data-clipboard-target="#shareUrl-copy-field">@lang('trans.copy')</button>
       </p>
        <p style="margin: 0; text-align: center; font-weight: bold;">@lang('trans.or')</p>
       <p style="margin: 0; text-align: center; font-size: 2rem;">
       		<a href="https://www.facebook.com/sharer/sharer.php?u=http://{{ config("app.urlInView") }}{{ Auth::user()->username }}" style="margin: 0px 5px;"><span class="fab fa-facebook"></span></a>
        	<a href="https://twitter.com/intent/tweet?text={{ Auth::user()->name }}%20http%3A%2F%2F{{ config("app.urlInView") }}{{ Auth::user()->username }}%20%23{{ config("app.name") }}%20%23feedback" style="margin: 0px 5px;"><span class="fab fa-twitter"></span></a>
        	<a href="https://plus.google.com/share?url=http://{{ config("app.urlInView") }}{{ Auth::user()->username }}" style="margin: 0px 5px;"><span class="fab fa-google-plus"></span></a>
       </p>
      </div>
    </div>
  </div>
</div>