@if(!json_decode($feedbacks))
<div class="post_card">
	<p style="text-align: center; padding: 15px; color: #a6b4c8;margin: 0px;">@lang('trans.nothingToShow')</p>
</div>
@else
<?php $sent_toId_index = 0;$commentsCount_index = 0; ?>
@foreach($feedbacks as $feedback)
<div class="post_card" @if(App::isLocale('ar')) style="text-align: right;direction: rtl" @endif data-post="{{ $feedback->pid }}" @if($feedback->read == 0) style="border-top: 1px solid red;" @endif>
	<div class="post_card_header">
		@if(Auth::user())
		<div class="dropdown" style="display: inline-flex;">
		  <a href="#" class="post_card_options" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="fas fa-ellipsis-h"></span>
		  </a>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="text-align: @lang('trans.align')">
		    <a class="dropdown-item" href="#">@lang('trans.report_post')</a>
		    <a class="dropdown-item" href="#">@lang('trans.block_user')</a>
		    @if(Auth::user())
			@if($feedback->to_id == Auth::user()->uid || $feedback->from_id == Auth::user()->uid)
		    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delModal_modal" data-deletefb="{{ $feedback->pid }}">@lang('trans.delete')</a>
		    @endif
		    @endif
		  </div>
		</div>
		@endif
		@if(isset($sent_toId))
		<span style="font-size: 11px; padding: 0px 8px;">@lang('trans.to') <a href="{{ route('profile',$sent_toId[$sent_toId_index]) }}">{{ $sent_toId[$sent_toId_index] }}</a></span>
		@endif
	</div>
	@if(!empty($feedback->image))
	<div class="post_card_image" @guest style="border-radius: 11px 11px 0px 0px;" @endguest>
		<img id="feedbackImg_preview" src="{{ asset('storage/fbImgs/'.$feedback->image) }}" />
	</div>
	@endif
	<div class="post_card_content" data-postContent="{{ $feedback->pid }}">
		<p>
			{!! nl2br(e($feedback->feedback)) !!}
		</p>
		<div><span class="timeNow">{{ $feedback->time }}</span></div>
		<div @if(App::isLocale('ar')) style="max-width: fit-content;margin-left: auto;" @endif>
		@if(Auth::user())
			@if($feedback->to_id == Auth::user()->uid)
			  <span class="switch switch-sm">
			    <input type="checkbox" class="switch" id="public_{{ $feedback->pid }}" @if($feedback->privacy == 1)  checked @endif>
			    <label style="margin: 0;" for="public_{{ $feedback->pid }}">@lang('trans.public')</label>
			  </span>
			@endif
			<label @if($feedback->to_id != Auth::user()->uid) style="margin: 0" @endif class="fb-comment" data-comment="{{ $feedback->pid }}"><span class="far fa-comment"></span> @lang('trans.addA_comment')</label>
		@endif
		</div>
	</div>
	@if(Auth::user())
	<div class="post_card_comments" data-commentCard="{{ $feedback->pid }}" data-show="0">
		<textarea dir="auto" maxlength="500" class="fb-comment-field" data-comment="{{ $feedback->pid }}" placeholder="@lang('trans.writeReplay')" style="direction: inherit;"></textarea>
		<button style="margin: 0px 10px;" class="fb-comment-btn" data-comment="{{ $feedback->pid }}"><span class="far fa-comment"></span> @lang('trans.send')</button>
	</div>
	@endif
	<div class="comments-card" data-cCard="{{ $feedback->pid }}">
		@if(isset($commentsCount))
		@if($commentsCount[$commentsCount_index] > 0)
		<a style="margin: 0px 15px;font-size: 11px;" class="show-comments" data-cshow="{{ $feedback->pid }}" href="javascript:void(0);"><span class="far fa-comments"></span> @lang('trans.showComments') {{ '('.$commentsCount[$commentsCount_index].')' }}</a>
		@endif
		@endif
	</div>
</div>
<?php $sent_toId_index++;$commentsCount_index++; ?>
@endforeach
{{-- ================= Delete modal ================= --}}
<div class="modal fade" id="delModal_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" data-delmodal-id="0">
    <div class="modal-content" style="border-radius: 30px;">
      <div class="modal-body" style="font-size: 12px; color: #7a7a7a;">
       <p style="text-align: center;font-size: 15px; color: #000; margin-bottom: 5px;">@lang('trans.deleteMSG')</p>
      </div>
      <div class="modal-footer" style="justify-content: center;">
        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('trans.cancel')</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-for="none" id="delModal_confirm">@lang('trans.delete')</button>
      </div>
    </div>
  </div>
</div>
@endif