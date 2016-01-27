var pathName = window.document.location.pathname;
var pathArray = window.location.pathname.split( '/' );
//var rootPath = "/" + pathArray[1];

var VegaCoreJs = {

	wrLoadScroll: "items-list",
		LoginPage:function(url){
		window.location.href=url;
	},
	removePrefixPhone: function(phone){
			if(phone!=null){
				var prefix_country = phone.substring(0, 2);
			    var prefix_zero = phone.substring(0, 1);
			    if (prefix_country == 84) {
			        return "0" + phone.substring(2, phone.length);
			    }
			    if (prefix_zero == "0" || prefix_zero == 0) {
			        return phone;
			    }
			    return "0" + phone;
			}
		},
	deletePl: function(id, url)
		{
		    var r = confirm(__t('Delete playlist'))
		    if (r == true)
		    {
		        $.ajax({
		            type: "GET",
		            url: url,
		            data: {},
		            async: false,
		            beforeSend: function() {
		            },
		            success: function(data) {
		                if (data == '1')
		                {
		                    alert(__t('You have successfully deleted your playlist'));
		                    $('#idpl-' + id).css({'display': 'none'});
		                }
		                else
		                {
		                    alert(__t('An error occurred while processing. Please try again later.'));
		                }
		            },
		            complete: function() {
		            },
		            statusCode: {
		                404: function() {
		                    alert("Lỗi kết nối");
		                    return false;
		                }
		            }
		        });

		    }
		    /*
		     else
		     {
		     alert("You pressed Cancel!")
		     }
		     */

		},
        playlistToggle: function(){
            if($('#imuzik-player-lst').css('display') == 'none'){
                $('#imuzik-player-lst').css("display","block");
                $('#imuzik-player-tools').css("display","block");
                $('.action ').css("display","none");
                $('.video').css("display","none");
                $('#video-collection').css("display","none");
                
                
            }else{
                $('#imuzik-player-lst').css("display","none");
                $('#imuzik-player-tools').css("display","none");
                 $('.action ').css("display","block");
                $('.video').css("display","block");
                $('#video-collection').css("display","block");
            }

        },
        
	loadmore: function(page_id)
		{
		    var zone = $("#" + page_id);
		    $('.load-more-page').show();
		    var link = $(".curent-link").attr("value");
		    var total_page = parseInt($(".total-page").attr("value"));
		    var curent_page = parseInt($(".curent-page").attr("value"));

		    nextPage = curent_page + 1;
		    if (nextPage <= total_page) {
		        xhr = $.ajax({
		            'url': link,
		            'data': {'page': nextPage, 'call_back': 1},
		            'type': 'GET',
		            'cache': false,
		            'async': false,
		            'beforeSend': function() {
		                $('.load-more-page').show();
		            },
		            'success': function(html) {
                                if(html == '1'){//ap dung cho load ajax favourite 
                                    alert(msgDetect);
                                    window.location.href = '/account/login';
                                    return false;
                                }
		                $(".load-more-page").hide();
		                $("."+VegaCoreJs.wrLoadScroll).append(html);
		                killScroll = false;
		                $(".curent-page").attr("value", curent_page+1);
		            },
		            'complete': function() {
		                $(".load-more-page").hide();
		                killScroll = false;
		            }
		        });
		    } else {
		        $(".load-more-page").hide();
		    }
		    return false;
		},
	likethis: function(type, contentId, action)
	{
	    if (!userPhone) {
                var r = confirm(msgDetect);
                if (r == true) {
                    window.location.href = rootPath + '/account/login?back=' + document.URL;
                    return false;
                } else {
                    return false;
                }
//	    	alert(msgDetect);
//	        window.location.href = '/account/login?back=' + document.URL;
//	        return false;
	    }

	    var wrrId = type + "-" + contentId;
	    var url = rootPath + '/default/like';
	    $.ajax({
	        url: url,
	        data: {type: type, id: contentId},
	        success: function(_data) {
	            if (_data == 'phone_not_detect') {
	                var html = '<a onclick="VegaCoreJs.likethis(\''+type+'\', '+contentId+', \'detail\');" href="javascript:;">'
					+		'<p>'
					+			'<i class="vg_icon icon_action_like"></i>'
					+		'</p>'
					+		'<p>'+ __t('Like')+'</p>'
					+'</a>';
	                $("#" + wrrId).html(html);
	                Popup.alert(msgDetect);
	            }
                    else {
                	var html = '<a onclick="VegaCoreJs.dislikethis(\''+type+'\', '+contentId+', \'detail\');" href="javascript:;">'
					+		'<p>'
					+			'<i class="vg_icon icon_action_dislike"></i>'
					+		'</p>'
					+		'<p>'+ __t('Unlike')+'</p>'
					+'</a>';
                	$("#" + wrrId).html(html);
	            }
	        },
	        beforeSend: function() {
	            $("#" + wrrId).html("<img width='34' height='29' src='/touch/images/ajax_loading.gif' />");
	        }
	    })
	    return false;
	},
	dislikethis: function(type, contentId, action)
	{
	    if (!userPhone) {
	        alert(msgDetect);
	        window.location.href = rootPath + '/account/login?back=' + document.URL;
	        return false;
	    }
	    var wrrId = type + "-" + contentId;
	    var url =  rootPath + '/default/dislike';
	    $.ajax({
	        url: url,
	        data: {type: type, id: contentId},
	        success: function(_data) {
	            if (_data == 'phone_not_detect') {
	            	Popup.alert(msgDetect);
	            } else {
                	var html = '<a onclick="VegaCoreJs.likethis(\''+type+'\', '+contentId+', \'detail\');" href="javascript:;">'
							+		'<p>'
							+			'<i class="vg_icon icon_action_like"></i>'
							+		'</p>'
							+		'<p>'+ __t('Like')+'</p>'
							+'</a>';
                    $("#" + wrrId).html(html);
	            }
	        },
	        beforeSend: function() {
	            $("#" + wrrId).html("<img width='34' height='29' src='/touch/images/ajax_loading.gif' />");
	        }
	    })
	    return false;
	},
	addSongPlaylist: function(href){
		if (!userPhone) {
                    if (confirm(msgDetect) == true) {
                    window.location.href = rootPath + '/account/login?back=' + document.URL;
                    return false;
                } 
	    }else{
	    	Popup.ajax(href);
	    }
		return false;
	},
	goHome: function() {
	    location.href = "/";
	},
	downloadRbt: function(href){
		if (!userPhone) {
            if (confirm(msgDetect) == true) {
            window.location.href = rootPath + '/account/login?back=' + document.URL;
            return false;
        } 
		}else{
			Popup.ajax(href);
		}
		return false;
	}
};

var Nav = {
    init: function() {
        var _this = this;

        $('.vg_mask').on('click', function() {
            _this.show()
            return false;
        });
        $('.icon_menu').on('click', function() {
            _this.show();
            return false;
        });
    },
    show: function() {
        var nav = $('#vg_nav');
        if (nav.hasClass('none')) {
            nav.removeClass('none');
            var height_w = $(window).height();
            $('#vg_wrapper').addClass('slideshowing').css('height', $("#vg_nav").height() + 'px');
            $('.vg_mask').css('height', $("#vg_nav").height() + 'px');
            $(".vg_menu").css('min-height',height_w+'px')
        } else {
            this.hide();
        }
        return this;
    },
    hide: function() {
        $('#vg_nav').addClass('none');
        $('#vg_wrapper').removeClass('slideshowing').css('height', 'auto');
    }
};
var Popup = {
	title_popup: 'Thông báo',
	position_popup: 'absolute',
    init: function() {
        $('.popup_inline').on('click', function() {
        	var id = $(this).attr("rel");
        	$("#vg_popup").html($("#"+id).html())
	        Popup.show();
	        return false;
        });
        $('.ajax_popup').on('click', function() {
        	var l = $(this).attr("href");
        	Popup.ajax(l);
        	/*$.ajax({
        		url: l,
        		type: "post",
        		success: function(response){
        			$("#vg_popup").html(response)
        			Popup.show();
        		}
        	})
            return false;*/
        	return false;
        });
    },
    ajax: function(href){
    	$.ajax({
    		url: href,
    		type: "post",
    		success: function(response){
    			$("#vg_popup").html(response);
    			if(href.indexOf("getPopupPlaylist")>0){
    				Popup.position_popup='absolute';
    			}
    			Popup.show();
    		}
    	})
    	return false;
    },
    alert: function(content,title, popup_type){
		if(title == "" || title == null)
		{
			title = Popup.title_popup
		}
    	var html_alert=
    		'<div id="Popup">'
		    +	'<a href="javascript:void(0)" onclick="Popup.close_popup_function(\''+popup_type+'\')" class="popup_close">X</a>'
		    +		'<div id="popup_wr">'
		    +			'<div class="popup_title">'
		    +				'<span id="pop_title">'+title+'</span>'
		    +			'</div>'
		    +			'<div class="popup_content">'
		    +			'<div style="padding: 10px; overflow: hidden">'
                    +			content
                    +			'</div>'
		    +			'</div>'
		    +		'</div>'
		    +	'</div>'
    	$("#vg_popup").html(html_alert)
        Popup.show();
    },
    close: function() {
        $('#vg_popup').addClass('none');
        $('#vg_popup').html("");
        $('#popup_mask').addClass('none');
        $("#vg_wrapper").css({
			height: 'auto'
		});
        $("#wrr-page").css({
			height: 'auto'
		})
    },
    
    show: function() {
    	$('#vg_popup').removeClass('none');
        $('#popup_mask').removeClass('none');
    	var height_doc = $(document).height();
    	var height_w = $(window).height();
    	var height_popup = $("#vg_popup").height();
    	
    	var width_w = $(window).width();
    	var widthpopup_w = $("#vg_popup").width();
    	
    	var pos_x = (width_w-widthpopup_w)/2
    	$("#wrr-page").css({
			overflow: 'hidden',
			height: height_w+'px'
		})
    	/*if(height_popup<height_w/2){
    		var m = height_w/2-height_popup;
    		console.log('m:'+m);
    		var position='absolute';
    	}else if(height_popup>height_w/2 && height_popup<height_w){
    		var m = (height_w-height_popup)/2;
    		var position='absolute';
    	}else{
    		var m = 20;
    		var position='absolute';
    		//var position='fixed';
    	}*/
    	var left = (width_w/2)-(widthpopup_w/2);
    	var top = (height_w/2)-(height_popup/2);
    	position = Popup.position_popup;
    	if(height_popup>height_w){
    		top=0;
    		position='absolute';
    		document.body.scrollTop=0;
    	}
    	/*console.log('left:'+left);
    	console.log('top:'+top);*/
    	/*console.log('height_doc:'+height_doc);
    	console.log('height_w:'+height_w);
    	console.log('height_popup:'+height_popup);*/
    	var p_mask_h='1500';
    	if(height_popup<height_w){
    		var p_mask_h = height_doc;
    		if(height_doc<height_w){
        		p_mask_h = height_w;
        	}
    	}else if(height_popup>height_w){
    		var p_mask_h = height_popup+100;
    	}else{
    		var p_mask_h = height_doc;
    	}
    	p_mask_h = height_w;
    	$("#vg_wrapper").css({
			height: p_mask_h+'px'
		});
    	//console.log('p_mask_h:'+p_mask_h);
    	 $('#popup_mask').css({
    		 height: p_mask_h+'px'
    	 });
    	 $('#vg_popup').css({
    		 top: top+'px',
    		 position: position,
    		 left: left+'px'
    	 });
    	 $('.popup_close').on('click', function() {
             Popup.close();
         });
    	 $('#popup_mask').on('click', function() {
             Popup.close();
         });

    },
	close_popup_function:function(popup_type){
		$.ajax({
			type: "GET",
			url: rootPath +"/ajax/setCookies",
			data: {type:popup_type,day:1},
			beforeSend: function() {
			},
			success: function(data) {
				//alert()
			},
			complete: function() {
			},
			statusCode: {
				404: function() {
					alert("Lỗi kết nối");
					return false;
				}
			}
		});
	}
};

$(document).ready(function(){
    Nav.init();
    Popup.init();

	$(".bt_submit").on("click", function(){
		$(this).parents("form").submit();
	});
});
function ClosePopup(type)
{
	$.ajax({
		type: "GET",
		url: rootPath +"/ajax/setCookies",
		data: {type:type,day:1},
		beforeSend: function() {
		},
		success: function(data) {
			//alert()
		},
		complete: function() {
		},
		statusCode: {
			404: function() {
				alert("Lỗi kết nối");
				return false;
			}
		}
	});
	Popup.close();
};

function RegisterPopup(){
	var type = 'popup_km';
	$.ajax({
		type: "GET",
		url: rootPath +"/ajax/setCookies",
		data: {type:type,day:1},
		beforeSend: function() {
		},
		success: function(data) {
			Popup.close();
			var link = rootPath +"account/doRegister?id=1";
			window.location = link;
		},
		complete: function() {
		},
		statusCode: {
			404: function() {
				alert("Lỗi kết nối");
				return false;
			}
		}
	});
}

function RegisterPopupKm(){
	var type = 'popup_km';
	$.ajax({
		type: "GET",
		url: rootPath +"/ajax/setCookies",
		data: {type:type,day:1},
		beforeSend: function() {
		},
		success: function(data) {
			Popup.close();
			var link = rootPath +"account/doRegister?id=1";
			window.location = link;
		},
		complete: function() {
		},
		statusCode: {
			404: function() {
				alert("Lỗi kết nối");
				return false;
			}
		}
	});

}
