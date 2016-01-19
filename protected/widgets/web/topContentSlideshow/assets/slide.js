var currentImage;
var currentIndex = -1;
var interval;
function showImage(index){
    if(index < $('#bigPic img').length - 0){
    	var indexImage = $('#bigPic img')[index];
        if(currentImage){
        	if(currentImage != indexImage ){
                $(currentImage).css('z-index',2);
                clearTimeout(myTimer);
                $(currentImage).fadeOut(250, function() {
				    myTimer = setTimeout("showNext()", 3000);
				    $(this).css({'display':'none','z-index':1})
				});
            }
        }

        var ulLeft = $("#body").offset().left;
        var curentThumb =  $("#thumbs li").eq(index);
        var tabLeft = $(curentThumb).position().left;

		var betw = tabLeft - ulLeft;
		if(betw>500){
			curentLeft = $("#thumbs").position().left;
			nextLeft = curentLeft - 100;
			$("#thumbs").animate({"left":nextLeft+"px"});
		}

		if(betw<95){
			$("#thumbs").animate({"left":"0px"});
		}



        $(indexImage).css({'display':'block', 'opacity':1});
        currentImage = indexImage;
        currentIndex = index;
        var link = $(indexImage).parent().attr('href');
        var artistLink = $(indexImage).parent().attr('rel');
        var artistName = $(indexImage).attr('title');
        $('#panel-overlay .slideshow_title').html($(indexImage).attr('alt'));
        $('#panel-overlay .slideshow_title').attr('href',link);
        $('#panel-overlay .slideshow_title').attr('title',$(indexImage).attr('alt'));

        $('#panel-overlay .slideshow_artist').html(artistName);
        $('#panel-overlay .slideshow_artist').attr('href','/search.html?'+artistLink);
        $('#panel-overlay .slideshow_artist').attr('title',artistName);

        
        $('#thumbs li').removeClass('active');
        $($('#thumbs li')[index]).addClass('active');
    }
}

function showNext(){
    var len = $('#bigPic img').length - 0;
    var next = currentIndex < (len-1) ? currentIndex + 1 : 0;
    showImage(next);
}

function showPrev(){
    var len = $('#bigPic img').length - 0;
    var prev = currentIndex > 0 ? currentIndex - 1 : 0;
    showImage(prev);
}


var myTimer;

$(document).ready(function() {
    myTimer = setTimeout("showNext()", 3000);
	showNext(); //loads first image
    $('#thumbs li').bind('click',function(e){
    	var count = $(this).attr('title');
    	showImage(parseInt(count)-1);
    });

    $("#nav-next").bind('click',function(e){
    	showNext();
    })
    $("#nav-prev").bind('click',function(e){
    	showPrev();
    })
});