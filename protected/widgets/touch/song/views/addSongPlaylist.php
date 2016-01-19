<div style="min-width: 250px" class="i-popup" data-role="popup"
	id="<?php echo $popupId;?>" data-theme="e" data-overlay-theme="a">
	<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d"
		style="margin: 0; width: 250px;">
		<div data-role="header" data-theme="a" class="ui-corner-top">
			<h1>THÊM VÀO THƯ VIỆN</h1>
			<a href="#"onclick="close_addPlaylist()" data-rel="back" data-role="button" data-theme="a"
				data-icon="delete" data-iconpos="notext"
				class="i-close ui-btn-right" style="position: absolute;">Close</a>
		</div>
		<div data-inset="false">
			<h2>PLAYLIST CỦA BẠN</h2>
			<ul data-role="listview" id="myplaylist">
            <?php if(count($playlist)>0):?>
				<?php foreach ($playlist as $key => $value):?>            
            		<li><a
					onclick="addToPlaylist('<?php echo Yii::app()->createUrl('/song/addToPlaylist', array('pid'=>$value->id));?>')"
					class="addPlaylist" href="javascript:void(0);"><?php echo $value->name;?></a></li>
            	<?php endforeach;?>
            <?php else:?>
            	<li>Bạn chưa có playlist nào.</li>
            <?php endif;?>
            </ul>
		</div>

		<div data-inset="false" style="background: #FEFEFE">
			<h2>TẠO PLAYLIST MỚI</h2>
			<table width="100%">
				<tr>
					<td><div class="adf">
							<input placeholder="Thêm playlist mới" id="new_playlist"
								class="giang i-input" type="text" name="playlist_name" value="" />
						</div></td>
					<td><button id="sb_playlist" class="i-button" type="submit">Thêm</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
function close_addPlaylist()
{
	$("#new_playlist").val('');
	$("#new_playlist").blur();
	return;
}
</script>
<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerScript ( 'add-to-playlist', "function addToPlaylist(url){
			if(!userPhone){
				alert(msgDetect);
				return false;
			}
			var url = url;
			if(window.location.hash) {
			      var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			      var hashArray = hash.split('_');
			      var id = hashArray[1];
			      // hash found
			  } else {
			      // No hash found
			      var id=0;
			  }

			if(id == 0 || id == 'undefined')
			{
				id = $('#detail_songid').val();
			}
			$.ajax({
					url: url,
					data: {songId: id},
					success: function(){
						alert('Bài hát đã được thêm vào playlist');
						$('#sb_playlist').focus();
						},
						
				})
		$('#new_playlist').blur();
			$('#" . $popupId . "').popup('close');
		
			return false;
		}", CClientScript::POS_END );
$urlCreatePlaylist = Yii::app ()->createUrl ( '/song/addNewPlaylist' );
$liItem = '<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-last-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text"><a href="/song/addToPlaylist?pid=1134" class="addPlaylist ui-link-inherit">sdtad asdfsdfs s</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
$cs->registerScript ( 'add-new-playlist', "$('#sb_playlist').on('click', function(){

			if(!userPhone){
				alert(msgDetect);
				return false;
			}
			var name = $.trim($('#new_playlist').val());
			$('#new_playlist').blur();
			var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			      var hashArray = hash.split('_');
				
			      var id = $.trim(hashArray[1]);
					if(id == 0 || id == 'undefined')
					{
						id = $('#detail_songid').val();
					}
			if(name==''){
				alert('Tên playlist không được để trống.');
				return false;
			}
				$.ajax({
				url:'" . $urlCreatePlaylist . "',
				data: {name:name,songId:id},
				success: function(data){
					if(data =='1')
		{
				alert('Tên playlist đã tồn tại');
				return false;
		}
		if (data =='2')
		{
			var html = '<li data-corners=\"false\" data-shadow=\"false\" data-iconshadow=\"true\" data-wrapperels=\"div\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"d\" class=\"ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-last-child ui-btn-up-d\"><div class=\"ui-btn-inner ui-li\"><div class=\"ui-btn-text\"><a onclick=\"addToPlaylist(\'/song/addToPlaylist?pid='+data+'\')\" href=\"javascript:void(0);\" class=\"addPlaylist ui-link-inherit\">'+name+'</a></div><span class=\"ui-icon ui-icon-arrow-r ui-icon-shadow\">&nbsp;</span></div></li>';
			$('#myplaylist').append(html);
			$('#new_playlist').val('');
			$('#" . $popupId . "').popup('close');
			$('#sb_playlist').focus();
			alert('Thành công');
		}
		else
		{
				alert('Có lỗi xảy ra, vui lòng thử lại sau');
				return false;
		}
								},
			  })
			return false;
		})", CClientScript::POS_END );
$cs->registerScript ( 'popupPlaylist', 'function onSuccess(){
			if(!userPhone){
				alert(msgDetect);
				return false;
			}
			$("#popupPlaylist").popup("open");
			$("#new_playlist").blur();
		 };', CClientScript::POS_END );
$cs->registerScript ( 'add_song_to_playlist', 'function add_song_to_playlist(){
			if(!userPhone){
				alert(msgDetect);
				return false;
			}
		 	$("#popupPlaylist").popup("open");
			$("#new_playlist").blur();
	 	 };', CClientScript::POS_END );

?>
