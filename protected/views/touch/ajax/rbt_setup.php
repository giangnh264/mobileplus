<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
	<div class="popup_title">
		<span id="pop_title">Cài đặt nhạc chờ</span>
	</div>
	<div class="popup_content">
		<div class="rbt-content">
	   		<div class="rbtname"><?php echo $rbtName;?></div>
	   		<div class="rbtprice">Giá: <?php echo $rbtPrice;?></div>
			<div class="rbt_player" id="rbt_player">
				<div class="vcontrols">
					<div class="v-play" id="v_play" onclick="play()"></div>
					<div class="v-pause" id="v_pause" onclick="pause()" style="display: none"></div>
				</div>
				<div class="now-playing">
					<div class="process-bar">
						<div class="curent-play" id="curent-play" style="width: 0%;">
							<div class="play-bar-node" id="seek"><span></span></div>
						</div>
					</div>
				</div>
			</div>
			<div style="display: none;">
				<input type="hidden" id="mp3_url" value="<?php echo $mp3Url;?>" />
				<input type="hidden" id="rbt_code" value="<?php echo $rbtCode;?>" />
				<audio controls preload="auto"  id="new_audio" ontimeupdate="updateProgressBar()">
				  <source src="" type="audio/mpeg">
				Your browser does not support the audio element.
				</audio>
			</div>
			<div class="rbt-action">
				<span class="button bt-actived" onclick="buyRbt()">Cài</span>
				<span class="button" onclick="giftRbt()">Tặng</span>
				<span onclick="Popup.close();" class="button">Hủy</span>
			</div>
   		</div>
	</div>
	</div>
</div>

<script type="text/javascript">

var audio = document.getElementById("new_audio");

function play()
{
	var audio = document.getElementById("new_audio");
	var mp3_url = $('#mp3_url').val();
	if(audio.src != mp3_url){
		audio.src = mp3_url;
	}
	try{
		audio.play();
		firstPlay = false;
	    $("#v_play").hide();
	    $("#v_pause").show();
	}catch(err){
	  alert("Lỗi:"+err.message);
	}
}
function pause()
{
	var audio = document.getElementById("new_audio");
	audio.pause();
	$("#v_play").show();
    $("#v_pause").hide();
}

function updateProgressBar(){
	var audio = document.getElementById("new_audio");
    var time_ = audio.currentTime * 100 / audio.duration;
    $("#curent-play").css('width',time_+'%');
    $("#song_time").html(formatSecondsAsTime(audio.currentTime));
}
function buyRbt(){
	if(!userPhone){
		alert(msgDetect);
		return false;
	}

	var rbtcode = $("#rbt_code").val();
	ret = docharge('downloadRbt',0,rbtcode);
	alert(ret.message);
	/* if(!ret){
		alert("Giao dịch không thành công. "+msgCharg);
	}else{
		alert("Mua nhạc chờ thành công");
	} */
	return false;
}
function giftRbt()
{
	if(!userPhone){
		alert(msgDetect);
		return false;
	}

	var rbtcode = $("#rbt_code").val();
	var phone =prompt("Nhập số điện thoại Vinaphone","");
	if(phone){
		toPhone = phone;
		phone = VegaCoreJs.removePrefixPhone(phone);
		ret = docharge('giftRbt',0,rbtcode);
		alert(ret.message);
		/* if(!ret){
			alert("Giao dịch không thành công. "+msgCharg);
		}else{
			alert("Tặng nhạc chờ thành công");
		} */
	}
	return false;
}
</script>