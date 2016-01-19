<a class="i-title-select "></a>
<div class="i-popup" data-role="popup" id="popuprbt" data-theme="none">
    <div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:280px;">
   		<div data-role="header" data-theme="a" class="ui-corner-top">
        	<h1>CÀI ĐẶT NHẠC CHỜ</h1>
        	<div class="close-popup" onclick="close_popup()" >&nbsp</div>

   		</div>
   		<div class="rbt-content">
	   		<div id="rbtname"></div>
	   		<div id="rbtprice"></div>
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
				<input type="hidden" id="mp3_url" />
				<input type="hidden" id="rbt_code" />
				<audio controls preload="auto"  id="new_audio" ontimeupdate="updateProgressBar()">
				  <source src="" type="audio/mpeg">
				Your browser does not support the audio element.
				</audio>
			</div>
			<div class="rbt-action">
				<span class="button actived" onclick="buyRbt()">Cài</span>
				<span class="button" onclick="giftRbt()">Tặng</span>
				<span onclick="close_popup()" class="button">Hủy</span>
			</div>
   		</div>
    </div><!-- /collapsible set -->
</div><!-- /popup -->


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
function close_popup(){
	$( "#popuprbt" ).popup( "close" );
	var audio = document.getElementById("new_audio");
	audio.pause();
	audio.currentTime = 0;
	$("#v_play").show();
    $("#v_pause").hide();
}
function buyRbt(){
	if(!userPhone){
		alert(msgDetect);
		return false;
	}

	var rbtcode = $("#rbt_code").val();
	ret = docharge('download_rbt',0,rbtcode);
	if(!ret){
		alert("Giao dịch không thành công. "+msgCharg);
	}else{
		alert("Mua nhạc chờ thành công");
	}
	return false;
}
function giftRbt()
{
	if(!userPhone){
		alert(msgDetect);
		return false;
	}

	var rbtcode = $("#rbt_code").val();
	var phone =prompt("Nhập số điện thoại Viettel","");
	toPhone = phone;
	phone = removePrefixPhone(phone);
	ret = docharge('giftRbt',0,rbtcode);
	if(!ret){
		alert("Giao dịch không thành công. "+msgCharg);
	}else{
		alert("Tặng nhạc chờ thành công");
	}
	return false;
}
</script>