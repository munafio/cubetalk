$('img').on('click',function(){
    $('#imgLightbox').show();
    $("#imgLightbox_preview").attr('src',$(this).attr('src'));
});

$('.imgLightboxClose').on('click',function() { 
    $('#imgLightbox').hide();
});

var clipboardElem = document.getElementById('shareUrl-copy-btn');
var clipboard = new ClipboardJS(clipboardElem);
