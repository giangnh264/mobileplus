﻿var pathName = window.document.location.pathname;
//var pathArray = window.location.pathname.split( '/' );
//var rootPath = "/" + pathArray[1];

var canPlay = false;
var firstPlaySong = true;
var firstPlayAlbum = true;
var index = 0;
var listPlayed =Array();

var vplayer = function (cssSelector, contentObj)
{
	var self = this;
	this.cssSelector = cssSelector;
	this.contentObj = contentObj;
	this.debug_mode = true;
	if(typeof debug_mode != 'undefined' ){
		this.debug_mode = debug_mode;
	}

	if(typeof userPhone != 'undefined' ){
		this.user_phone = userPhone;
	}
	this.audio = document.getElementById(cssSelector);
	//this.audio.volume=0; // Only development mode
	this.progressHolder = document.getElementById("progress_box");

	$("#play").click(function() {
		self._play();
		return false;
	});

	$("#pause").click(function() {
		self._pause();
		return false;
	});
	/*Seek*/
	$("#progress_box").mouseup(function(e) {
		self._setPlayProgress(e.pageX);
    }, true);


	document.getElementById("hand_progress").addEventListener("mousedown", function() {
        document.onmousemove = function(e) {
        	self._setPlayProgress(e.pageX);
        };
        document.onmouseup = function() {
            document.onmousemove = null;
            document.onmouseup = null;
            self._trackPlayProgress();
        };
    }, true);
}
vplayer._getInstance = function() {
    if (!vplayer._instance)
    	vplayer._instance = new vplayer('audio',null);
    return vplayer._instance;
};

vplayer.prototype = {
	_play:function(){

	},
	_pause: function(){
		this.audio.pause();
		$('#play').css('display','block');
    	$('#pause').css('display','none');
	},
    _charging: function(action, contentId, contentCode){
    	return docharge(action, contentId, contentCode);
    	//return {errorCode:1,message:'Error'};
    },
    _trackPlayProgress: function(){
    	var time = this.audio.currentTime * 100 / this.audio.duration;
    	 $("#play_progress").css('width',time+'%');
    	 var hand  = (((this.audio.currentTime / this.audio.duration) * (this.progressHolder.offsetWidth - 2)) - 7) + "px";
    	 $("#hand_progress").css('left',hand);
    },
    _setPlayProgress:function(clickX){
        var newPercent = Math.max(0, Math.min(1, (clickX - findPosX(this.progressHolder)) / this.progressHolder.offsetWidth));
        this.audio.currentTime = newPercent * this.audio.duration;
        playProgressBar = newPercent * (this.progressHolder.offsetWidth - 2) + "px";
        $("#play_progress").css("width",playProgressBar);
        handControl = ((newPercent * (this.progressHolder.offsetWidth - 2)) - 7) + "px";
        $("#hand_progress").css('left',handControl);
        //updateTimeDisplay();
    },
    _reload: function(){
    	this.audio.currentTime = 0;
    	this._trackPlayProgress();
		$('#play').css('display','block');
    	$('#pause').css('display','none');
    },
    _logPlayFree: function (type,contentId){
		var time = new Date().getTime() / 1000;

        $.ajax({
            type: "GET",
            url: urlLogPlayWifi,
            data: {type: type, id: contentId,t:time},
            async: false,
            beforeSend: function() {
            },
            success: function(data) {
            },
            complete: function() {
            },
            statusCode: {
            }
        });
    },
    _checkLimitPlayWifi: function()
    {
		var time = new Date().getTime() / 1000;
        $.ajax({
            type: "GET",
            url: urlCheckPlayWifi,
            data: {t:time},
            async: false,
            beforeSend: function() {
            },
            success: function(data) {
            	ret =  data;
            },
            complete: function() {
            },
            statusCode: {
            	404: function() {
            		ret = {error:404, message:"Error connect to charging"};
                }
            }
        });
        return ret;
    },
    _checkPlayNoSub: function()
    {
		var time = new Date().getTime() / 1000;
        $.ajax({
            type: "GET",
            url: urlCheckPlayNoSub,
            data: {t:time},
            async: false,
            beforeSend: function() {
            },
            success: function(data) {
            	ret =  data;
            },
            complete: function() {
            },
            statusCode: {
            	404: function() {
            		ret = {error:404, message:"Error connect to charging"};
                }
            }
        });
        return ret;
    },
    _getPriceContent: function(contentID, actionTYPE)
    {
		var time = new Date().getTime() / 1000;
        $.ajax({
            type: "GET",
            url: rootPath + '/ajax/getContentPrice',
            data: {id:contentID, action:actionTYPE, t:time},
            async: false,
            beforeSend: function() {
            },
            success: function(data) {
            	ret =  data;
            },
            complete: function() {
            },
            statusCode: {
            	404: function() {
            		ret = {error:404, message:"Error connect to charging"};
                }
            }
        });
        return ret;
    },
	_limitContent: function(){
		back_url = document.URL;
		url = rootPath + '/account/login?back=' + back_url;
		var return_code = 0;
		$.ajax({
			type: "GET",
			url: urlLimit,
			data: {},
			async: false,
			beforeSend: function() {
			},
			success: function(data) {
				ret =  data;
				if(ret >= 5){
					html =
						'<p class="padB10">Quý khách đã nghe/xem hết 5 nội dung miễn phí trong lần truy cập này. Để được miễn phí nghe xem không giới hạn các bài hát, video vui lòng đăng nhập dịch vụ.</p>'
						+'<div class="pk-btn">'
						+'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Đóng</a>'
						+'<a class="button-dark btn-submit" href="'+url+'">Đồng ý</a>'
						+'</div>'
					Popup.alert(html);
					return_code = 1
				}
			},
			complete: function() {
			},
			statusCode: {
				404: function() {
					ret = {error:404, message:"Error connect to charging"};
				}
			}
		});
		return return_code;
	},
	_limitContentCtkm: function(){
		url = rootPath + '/account/package';
		var return_code = 0;
		$.ajax({
			type: "GET",
			url: urlLimitCtkm,
			data: {},
			async: false,
			beforeSend: function() {
			},
			success: function(data) {
				ret =  data;
				if(ret.session == 3 && ret.promotion == 1){
					html =
						'<div class="promotion_popup">'
						+'<p class="padB5">MIỄN PHÍ <span class="text_promotion"> 05 ngày </span>nghe/xem/tải nhạc chất lượng cao miễn phí <span class="text_promotion"> 3G/GPRS </span></p>'
						+'<p class="padB5">Cơ hội trúng<span class="text_promotion"> HONDA LEAD </span> và nhiều phần quà giá trị </p>'
						+'<div class="pk-btn">'
						+'<a class="button-dark btn-submit" href="'+url+'">Đăng ký</a>'
						+'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Để sau</a>'
						+'</div>'
						+'</div>'
					Popup.alert(html,'Niềm vui nhân đôi');
					return_code = 0
				}else if(ret.session == 3 && ret.promotion == 0){
					html =
						'<div class="promotion_popup">'
						+'<p class="padB10">Chưa bao giờ sở hữu<span class="text_promotion"> HONDA LEAD </span>và thưởng thức các ca khúc chất lượng cao hoàn toàn<span class="text_promotion"> MIỄN PHÍ 3G/GPRS </span>dễ dàng đến thế!</p>'
						+'<div class="pk-btn">'
						+'<a class="button-dark btn-submit" href="'+url+'">Đăng ký</a>'
						+'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Để sau</a>'
						+'</div>'
						+'</div>'
					Popup.alert(html,'Khuyến mại');
					return_code = 0
				}
			},
			complete: function() {
			},
			statusCode: {
				404: function() {
					ret = {error:404, message:"Error connect to charging"};
				}
			}
		});
		return return_code;
	},

	_checkContent: function(){
		back_url = document.URL;
		url = rootPath + '/account/login?back=' + back_url;
		var return_code = 0;
		$.ajax({
			type: "GET",
			url: 'ajax/checkContent',
			data: {},
			async: false,
			beforeSend: function() {
			},
			success: function(data) {
				ret =  data;
				if(ret >= 5){
					html =
						'<p class="padB10">Quý khách đã nghe/xem hết 5 nội dung miễn phí trong lần truy cập này. Để được miễn phí nghe xem không giới hạn các bài hát, video vui lòng đăng nhập dịch vụ.</p>'
						+'<div class="pk-btn">'
						+'<a class="button-grey btn-submit" href="javascript:void(0);" onclick="Popup.close()">Đóng</a>'
						+'<a class="button-dark btn-submit" href="'+url+'">Đồng ý</a>'
						+'</div>'
					Popup.alert(html);
					return_code = 1
				}

			},
			complete: function() {
			},
			statusCode: {
				404: function() {
					ret = {error:404, message:"Error connect to charging"};
				}
			}
		});
		return return_code;
	}
}


var audioPlayer = function(cssSelector, contentObj)
{
	vplayer.call(this,cssSelector,contentObj);

	var self = this;
	document.getElementById("audio").addEventListener("ended",
			function() {
				self._reload();
			}, false);

}

audioPlayer._getInstance = function() {
    if (!audioPlayer._instance)
    	audioPlayer._instance = new audioPlayer('audio',null);
    return audioPlayer._instance;
};

audioPlayer.prototype =  $.extend(true, vplayer.prototype,{
    _play: function(){
    	 if($("#play").hasClass("before-load")){
    		 	//alert("Xin vui lòng chờ khi media đang tải media");
    	        return false;
    	 }

    	if(firstPlaySong && this.user_phone){
			try {
				if(userSubs=='false' || userSubs==false){
					if(this._limitContentCtkm()== 1){
						return true;
					}
				}
				ret = this._charging("playSong",this.contentObj.id,this.contentObj.code);

			}
			catch(err) {

			}

    	}

    	if((!this.user_phone || typeof this.user_phone == 'undefined') && firstPlaySong){
			if(this._limitContent()== 1){
				return false;
			}
    	}


		//playInterval = setInterval(checkStatus, 33);
		this.audio.play();
		firstPlaySong = false;
		$('#play').css('display','none');
		$('#pause').css('display','block');

    },
	_logAlbum: function(albumid){
		back_url = document.URL;
		url = rootPath + '/ajax/LogAlbum';
		var return_code = 0;
		$.ajax({
			type: "GET",
			url: url,
			data: {id:albumid},
			async: false,
			beforeSend: function() {
			},
			success: function(data) {
				return_code = 1

			},
			complete: function() {
			},
			statusCode: {
				404: function() {
					ret = {error:404, message:"Error connect to charging"};
				}
			}
		});
		return return_code;
	},
    _play_confirm: function(contentObj){
    	contentID = $("#obj_id").val();
    	contentCODE = $("#obj_code").val();


    	ret = this._charging("playSong",contentID,contentCODE);
    	console.log("do charging after confirm");
		if(ret.errorCode != 0){
			alert(ret.message);
			Popup.close();
			return false;
		}
		Popup.close();
    	this.audio.play();

    	firstPlaySong = false;
    	$('#play').css('display','none');
    	$('#pause').css('display','block');
    }
})

if(page_id == 'videoPlaylist-view' ){


	var VideoPlaylistPlayer = function(cssSelector, contentObj)
	{
        //alert(JSON.stringify(contentObj));
        var self = this;
		document.getElementById("video-player-obj").addEventListener("ended", function() {
           /* $('#video-poster').show();
            $('#video-tag').hide();*/
            var listSong = contentObj.listSong;
			index = (index + 1 < listSong.length) ? index + 1 : 0;
			self._play();
		}, false);
        $(".item-video-playlist").click(function(){
            /*$('#video-poster').show();
            $('#video-tag').hide();*/
            var id_item = $(this).attr("id");
            id_item = id_item.replace("video-item-","");
            index = parseInt(id_item);
            var listSong = contentObj.listSong;
            if(index >= 0 && index <= listSong.length){
                self._play();
            }
        });
	};
	VideoPlaylistPlayer._getInstance = function() {
		if (!VideoPlaylistPlayer._instance)
			VideoPlaylistPlayer._instance = new VideoPlaylistPlayer('video',null);
		return VideoPlaylistPlayer._instance;
	};
	VideoPlaylistPlayer.prototype =  $.extend(true, vplayer.prototype,{
		_play: function(){
            $("#imuzik-player-lst ul li").removeClass("selected");
            $("#video-item-"+index).addClass("selected");
            if ($(".playHd").find("span").hasClass("nhd")) {
                var url = listSong[index].url_hd;
            } else {
                var url = listSong[index].url_normal;
            }
            var img = listSong[index].img;
            var videoPlayer = document.getElementById("video-player-obj");
            videoPlayer.src = url;

            $("#video-poster").css('background-image', 'url(' + img + ')');
            videoPlayer.load();
            videoPlayer.play();
        }

	})
}

if(page_id == 'album-view' || page_id=='horoscopes-detail' || page_id=='horoscopes-view'){
var albumPlayer = function(cssSelector, contentObj)
{
	var self = this;
	vplayer.call(this,cssSelector,contentObj);

	$("#next").click(function() {
		if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
			alert("Danh sách bài hát rỗng");
			return false;
		}
		var listSong = self.contentObj.listSong;

		index = (index + 1 < listSong.length) ? index + 1 : 0;
		self._play();
		return false;
	});
	$("#prev").click(function() {
		if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
			alert("Danh sách bài hát rỗng");
			return false;
		}
		var listSong = self.contentObj.listSong;

		if (index == 'undefined')
			index = 0;
		else if (index <= 0)
			index = listSong.length - 1;
		else
			index--;
		self._play();
		return false;
	});
	self._logAlbum(self.contentObj.id);
	document.getElementById("audio").addEventListener("ended",
	function() {
		var listSong = self.contentObj.listSong;
		index = (index + 1 < listSong.length) ? index + 1 : 0;
		self._play();
	}, false);

	$(".item-in-list").click(function(){
		var id_item = $(this).attr("id");
		id_item = id_item.replace("item-","");
		index = parseInt(id_item);
		var listSong = self.contentObj.listSong;
		if(index >= 0 && index <= listSong.length){
			self._play();
		}
	});
	$("#lyric-icon").click(function(){
		if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
			alert("Danh sách bài hát rỗng");
			return false;
		}

		var listSong = self.contentObj.listSong;
		var element = "#lyric-"+listSong[index].id;
		var lyric = $(element).html();
		Popup.title_popup = __t('Lyric');
		//Popup.alert(listSong[index].lyric==''?"Chưa có lời":lyric);
		Popup.alert(lyric);
		return false;
	})
    }
    albumPlayer._getInstance = function() {
		if (!albumPlayer._instance)
            albumPlayer._instance = new albumPlayer('audio',null);
        return albumPlayer._instance;
    };

albumPlayer.prototype =  $.extend(true, vplayer.prototype,{
	 _play: function(){
		if(typeof this.contentObj.listSong == 'undefined' ||  this.contentObj.listSong.length ==0){
			alert("Danh sách bài hát rỗng");
			return false;
		}

		$("#listSong li").removeClass("active_play");
		$("#item-"+index).addClass("active_play");
    	var listSong = this.contentObj.listSong;

		// Nhan dien dc TB va chua charg noi dung nay thi goi charging
    	if(this.user_phone){
	    	if(!in_array(listPlayed,listSong[index].id)){
	    		var content_price = listSong[index].listen_price;
	    		ret = this._charging("playSong",listSong[index].id,listSong[index].code);
	    		console.log("do charging");
	    	}
	    	var item = {id:listSong[index].id}
			listPlayed.push(item);
    	}else{
			//this._limitContent();
			if(this._limitContent()== 1){
				return false;
			}
    	}

    	var url = listSong[index].mp3;
    	var src = this.audio.src;
    	if(src==''){
    		src = $("#mp3_src").attr("src");
    	}
    	if(src != url){
    		this.audio.src = url;
    		$("#mp3_src").attr("src",url)
    		if(os=='ANDROIDOS' && os_version<2.4){
    			this.audio.load();
    		}

    	}
    	this.audio.play();
    	$('#play').css('display','none');
    	$('#pause').css('display','block');
    	var duration = this.audio.duration;
    	if(isNaN('duration')){
    		duration = listSong[index].duration;
    	}
    	var time = formatTime(duration);
    	$("#current_time_display").text(time);
    	$("#song-playing").text(listSong[index].title);
	 },
    _play_confirm: function(){
    	contentTITLE = $("#obj_title").val();
    	contentID = $("#obj_id").val();
    	contentCODE = $("#obj_code").val();
    	contentURL = $("#obj_url").val();
    	contentDURATION = $("#obj_duration").val();

		ret = this._charging("playSong",contentID,contentCODE);

		console.log("do charging after confirm");
    	var item = {id:contentID}
		listPlayed.push(item);

       	var url = contentURL;
    	var src = this.audio.src;
    	if(src==''){
    		src = $("#mp3_src").attr("src");
    	}
    	if(src != url){
    		this.audio.src = url;
    		$("#mp3_src").attr("src",url)
    		if(os=='ANDROIDOS' && os_version<2.4){
    			this.audio.load();
    		}

    	}
    	this.audio.play();
    	$('#play').css('display','none');
    	$('#pause').css('display','block');
    	var duration = this.audio.duration;
    	if(isNaN('duration')){
    		duration = contentDURATION;
    	}
    	var time = formatTime(duration);
    	$("#current_time_display").text(time);
    	$("#song-playing").text(contentTITLE);
    	Popup.close();
    }
})
}


if(page_id == 'playlist-view'){
	var playlistPlayer = function(cssSelector, contentObj)
	{
		var self = this;
		vplayer.call(this,cssSelector,contentObj);

		$("#next").click(function() {
			if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
				alert("Danh sách bài hát rỗng");
				return false;
			}
			var listSong = self.contentObj.listSong;

			index = (index + 1 < listSong.length) ? index + 1 : 0;
			self._play();
			return false;
		});
		$("#prev").click(function() {
			if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
				alert("Danh sách bài hát rỗng");
				return false;
			}
			var listSong = self.contentObj.listSong;

			if (index == 'undefined')
				index = 0;
			else if (index <= 0)
				index = listSong.length - 1;
			else
				index--;
			self._play();
			return false;
		});

		document.getElementById("audio").addEventListener("ended",
		function() {
			var listSong = self.contentObj.listSong;
			index = (index + 1 < listSong.length) ? index + 1 : 0;
			self._play();
		}, false);

		$(".item-in-list").click(function(){
			var id_item = $(this).attr("id");
			id_item = id_item.replace("item-","");
			index = parseInt(id_item);
			var listSong = self.contentObj.listSong;
			if(index >= 0 && index <= listSong.length){
				self._play();
			}
		});
		$("#lyric-icon").click(function(){
			if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
				alert("Danh sách bài hát rỗng");
				return false;
			}
			var listSong = self.contentObj.listSong;
			var element = "#lyric-"+listSong[index].id;
			var lyric = $(element).html();
			Popup.title_popup = 'Lời bài hát';
			//Popup.alert(listSong[index].lyric==''?"Chưa có lời":lyric);
			Popup.alert(lyric);
			return false;
		})
	}
	playlistPlayer.prototype =  $.extend(true, vplayer.prototype,{
		 _play: function(){
			if(typeof this.contentObj.listSong == 'undefined' ||  this.contentObj.listSong.length ==0){
				alert("Danh sách bài hát rỗng");
				return false;
			}
			if(!this.user_phone){
				alert("Chức năng chỉ dành cho các thuê bao Vinaphone");
				return false;
			}
			$("#listSong li").removeClass("active_play");
			$("#item-"+index).addClass("active_play");

	    	var listSong = this.contentObj.listSong;
	    	if(!in_array(listPlayed,listSong[index].id)){
                    if(userSubs=='false' || userSubs==false){
	    			  // Chua dang ky goi cuoc -> Check gia noi dung va charg 24h
	    			  var getPriceCharg = this._getPriceContent(listSong[index].id,"play_song");
	    			  if(getPriceCharg && getPriceCharg.errorCode == 0){
	    				  var content_price = getPriceCharg.data.price;
	    			  }else{
	    				  var content_price = song_price;
	    			  }
	    			  if(content_price > 0){
               				var html = __t("Please register to play this song for free or continue to play by paying ") + content_price + " KHR";
	    				html += '<input type="hidden" name="obj_title" id="obj_title" value="'+listSong[index].title+'" />';
	    				html += '<input type="hidden" name="obj_id" id="obj_id" value="'+listSong[index].id+'" />';
	    				html += '<input type="hidden" name="obj_code" id="obj_code" value="'+listSong[index].code+'" />';
	    				html += '<input type="hidden" name="obj_url" id="obj_url" value="'+listSong[index].mp3+'" />';
	    				html += '<input type="hidden" name="obj_duration" id="obj_duration" value="'+listSong[index].duration+'" />';
	    				html += '<div class="clb ovh">';
	    				html += '<div class="btn-popup btn-popup-green" style="width: 45%; float: left;">';
	    				html += '<a href="/account/package" class="show" style="color: #FFF">'+ __t('Register') +'</a>';
	    				html += '</div>';

	    				html += '<div class="btn-popup btn-popup-green" style="width: 45%; float: right;">';
	    				html += '<a href="javascript:void(0)"  class="show" style="color: #FFF" onclick="audioPlayer._getInstance()._play_confirm()" >'+ __t('Listen') +' ('+content_price+' KHR)</a>';
	    				html += '</div>';
	    				html += '</div>';
	    				Popup.alert(html);
	    				return false;
	    			}
	    		}
	    		ret = this._charging("playSong",listSong[index].id,listSong[index].code);

	    		console.log("do charging");
	    	}
	    	var item = {id:listSong[index].id}
			listPlayed.push(item);

	    	var url = listSong[index].mp3;
	    	var src = this.audio.src;
	    	if(src==''){
	    		src = $("#mp3_src").attr("src");
	    	}
	    	if(src != url){
	    		this.audio.src = url;
	    		if(os=='ANDROIDOS' && os_version<2.4){
	    			this.audio.load();
	    		}
	    	}

	    	this.audio.play();
	    	$('#play').css('display','none');
	    	$('#pause').css('display','block');
	    	var duration = this.audio.duration;
	    	if(isNaN('duration')){
	    		duration = listSong[index].duration;
	    	}
	    	var time = formatTime(duration);
	    	$("#current_time_display").text(time);
	    	$("#song-playing").text(listSong[index].title);
		 }
	})
	}




function myOnCanPlayFunction() {
	canPlay = true;
	$("#play").removeClass("before-load");
	$("#play").html("");
	console.log('Can play');
}
function myOnCanPlayThroughFunction() {
	console.log('Can play through');
}
function myOnLoadedData() {}

function updateProgressBar(){
	vplayer._getInstance()._trackPlayProgress();
}

function formatTime(seconds) {
    seconds = Math.round(seconds);
    minutes = Math.floor(seconds / 60);
    minutes = (minutes >= 10) ? minutes : "0" + minutes;
    seconds = Math.floor(seconds % 60);
    seconds = (seconds >= 10) ? seconds : "0" + seconds;
    return minutes + ":" + seconds;
}

function findPosX(obj) {
    var curleft = obj.offsetLeft;
    while (obj = obj.offsetParent) {
        curleft += obj.offsetLeft;
    }
    return curleft;
}
function checkStatus()
{
	var audio = document.getElementById("audio");
	if(audio.currentTime > 0){
		clearInterval(playInterval);
	}else{
		audio.play()
	}

}