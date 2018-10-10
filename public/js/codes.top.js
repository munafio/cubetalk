$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="astoken"]').attr('content')
  }
});
var loading_image = $('meta[name="loadimg"]').attr('content');
var path = $('meta[name="path"]').attr('content');
$(document).ready(function() {
	var data_options = $("#data-options").html();
	var do_json = JSON.parse(data_options);
	var d = new Date().getTime();
	$('#feedback_hidden').attr('value',d);
	 $(".navbar-search-field").on('keyup',function() {
	 	$(".navbar-search-card").show();
	 	var search_user = $(this).val();
	 	if ($(this).val() != "") {
			$.ajax({
		       url: path+"/searchUsers",
		       type:'post',
		       data:{'input':search_user,'path':path},
		       beforeSend(){
		          $(".navbar-search-card").html("<p style='text-align: center;width: 100%;color: gray;font-size: 12px;margin: 3px'><img style='width:18px;' src='"+loading_image+"' /></p>");
		       },
		       success:function(data){
		          $(".navbar-search-card").html(data);
		       }
		    });
	 	}else{
	 		$(".navbar-search-card").html('');
	 		$(".navbar-search-card").hide();
	 	}      
	 });
	 $(".navbar-search-card").on("mousedown",function(e){
	 	e.preventDefault();
	});
	$(".navbar-search-field").blur(function(){
	    $(".navbar-search-card").hide();
	});
	function imagePreview(input,elm) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $(elm).css("background-image","url('"+e.target.result+"')");
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$("#settings_img").on("change",function(){
	    imagePreview(this,"#settings_img_elm");
	});
	$("#feedback_hFile").on("change",function(){
		$(".send_feedback_image").show();
	    imagePreview(this,"#sfb_image_preview");
	});
	$("#sfb_image_preview_x").on("click",function(){
	   $(".send_feedback_image").hide();
	   $('#feedback_hFile').val("");
	});
	$('.timeNow').bind('change', function () {
		var time = parseInt($(this).html());
		var date = new Date(time);
		var today = new Date();
		if (today.toLocaleDateString() == date.toLocaleDateString()) {
			$(this).html(do_json.today+", "+date.toLocaleTimeString());
		}else{
			$(this).html(date.toLocaleString());
		}
    });
    $('.timeNow').trigger('change');

    $('.switch').on('click',function(){
    	var pid = $(this).attr('id');
    	if ($('#'+pid).is(':checked')) {
	    	var status = "true";
	    }else{
	    	var status = "false";
	    }
	    $.ajax({
	    	url: path+"/postPrivacy",
	        type:'post',
	        data:{'pid':pid,'status':status},
	    	error:function(data){
	    		alert(data);
	    	}
	    });
    });
    $('.fb-comment').on('click',function(){
    	var commentFor = $(this).data('comment');
    	if ($('[data-commentCard~="'+commentFor+'"]').data('show') == "0") {
    		$('[data-commentCard~="'+commentFor+'"]').slideDown('fast');
    		$('[data-commentCard~="'+commentFor+'"]').data('show',"1");
    	}else{
    		$('[data-commentCard~="'+commentFor+'"]').slideUp('fast');
    		$('[data-commentCard~="'+commentFor+'"]').data('show',"0");
    	}
    });
    $('.fb-comment-btn').on('click',function(){
    	var cTime = new Date().getTime();
    	var pid = $(this).data('comment');
    	var comment = $('.fb-comment-field[data-comment~="'+pid+'"]').val();
    	if (!$.trim(comment) == "") {
    	$.ajax({
    		url: path+'/comment',
    		type: "post",
    		data:{'pid':pid,'comment':comment,'cTime':cTime,'path':path},
    		beforeSend:function(){
    			$('.fb-comment-btn[data-comment~="'+pid+'"]').hide();
    			$('.post_card_comments[data-commentCard~="'+pid+'"]').append('<img style="width:18px;margin:0px 13px;" src="'+loading_image+'" data-loading="'+pid+'" />');
    		},
    		success:function(data){
    			$('.fb-comment-field[data-comment~="'+pid+'"]').val('');
    			$('.fb-comment-btn[data-comment~="'+pid+'"]').show();
    			$('[data-loading~="'+pid+'"]').remove();
    			$('[data-commentCard~="'+pid+'"]').slideUp('fast');
    			$('[data-commentCard~="'+pid+'"]').data('show',"0");
    			$('.comments-card[data-ccard~="'+pid+'"]').append(data);
    		}
    	});
    	}else{
    		$('.fb-comment-field[data-comment~="'+pid+'"]').focus();
    	}
    });
    $('.show-comments').on('click',function(){
    	var pid = $(this).data('cshow');
    	$.ajax({
    		url: path+'/showComments',
    		type: "post",
    		data:{'pid':pid,'path':path},
    		beforeSend:function(){
    			$('.show-comments[data-cshow~="'+pid+'"]').remove();
    			$('.comments-card[data-ccard~="'+pid+'"]').prepend('<img style="width:18px;margin:0px 13px;" src="'+loading_image+'" data-loading="'+pid+'" />');
    		},
    		success:function(data){
    			$('[data-loading~="'+pid+'"]').remove();
    			$('.comments-card[data-ccard~="'+pid+'"]').html(data);
    			
				$('.cTimeNow').bind('change', function () {
				var time = parseInt($(this).html());
				var date = new Date(time);
				var today = new Date();
				if (today.toLocaleDateString() == date.toLocaleDateString()) {
					$(this).html(do_json.today+", "+date.toLocaleTimeString());
				}else{
					$(this).html(date.toLocaleString());
				}
				
		    });
		    $('.cTimeNow').trigger('change');
    		}
    	});
    });
    $('[data-deletefb]').on('click',function(){
    	$('.modal-dialog').data('delmodal-id',$(this).data('deletefb'));
    	$('#delModal_confirm').data('for','post');
    });
    $('#delModal_confirm').on('click',function(){
    	if ($(this).data('for') == "post") {
	    	var pid = $('.modal-dialog').data('delmodal-id');
	    	$.ajax({
	    		url: path+'/deletePost',
	    		type: "post",
	    		data:{'pid':pid},
	    		success:function(data){
	    			if (data == "done") {
	    				$('.post_card[data-post~="'+pid+'"]').remove();
	    			}else{
	    				alert(data);
	    			}
	    		}
	    	});
    	}
	});
	$(this).on("click","[data-cdelete]", function () {
		$('.modal-dialog').data('delmodal-id',$(this).data('cdelete'));
		$('#delModal_confirm').data('for','comment');
	});
	$('#delModal_confirm').on('click',function(){
		if ($(this).data('for') == "comment") {
	    	var cid = $('.modal-dialog').data('delmodal-id');
	    	$.ajax({
	    		url: path+'/deleteComment',
	    		type: "post",
	    		data:{'cid':cid},
	    		success:function(data){
	    			if (data == "done") {
	    				$('.comment-item[data-comment~="'+cid+'"]').remove();
	    			}else{
	    				alert(data);
	    			}
	    		}
	    	});
    	}
	});
});

