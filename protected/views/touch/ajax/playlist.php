<?php if(empty($phone)):?>
<script>
alert(msgDetect);
</script>
<?php else:?>
<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
	<div class="popup_title">
		<span id="pop_title"><?php echo Yii::t("wap","Thêm vào playlist");?></span>
	</div>
	<div class="popup_content">
		<ul class="list_genre">
			<li><a href="#"><?php echo Yii::t("wap","Playlist của tôi");?></a>
			<ul class="sub_list_genre" id="myplaylist">
            	<?php if(count($playlist)>0):?>
					<?php foreach ($playlist as $key => $value):?>            
            		<li><a onclick="addToPlaylist('<?php echo Yii::app()->createUrl('/song/addToPlaylist', array('pid'=>$value->id));?>')"
					class="addPlaylist" href="javascript:void(0);"><?php echo CHtml::encode($value->name);?></a>
					</li>
            		<?php endforeach;?>
            	<?php else:?>
            		<li><?php echo Yii::t("wap","Bạn chưa có playlist nào.");?>.</li>
            	<?php endif;?>
			</ul>
			</li>
			<li>
				<div class="add_pl">
					<table width="100%">
						<tr>
							<td><div class="adf">
									<input placeholder="<?php echo Yii::t("wap","Tạo playlist mới");?>" id="new_playlist"
										class="i-input" type="text" name="playlist_name" value="" />
								</div></td>
							<td width="50"><button id="sb_playlist" class="i-button" type="submit"><?php echo Yii::t("wap","Tạo");?></button></td>
						</tr>
					</table>
				</div>
			</li>
		</ul>
	</div>
	</div>
</div>
<?php
$cs = Yii::app ()->getClientScript ();
$cs->registerScript ( 'add-to-playlist', "function addToPlaylist(url){
			if(!userPhone){
				alert(msgDetect);
				return false;
			}
			var url = url;
			id = ".$songId.";
			
			$.ajax({
					url: url,
					data: {songId: id},
					success: function(){
                                                alert(__t('successfully added to playlist'));
						$('#sb_playlist').focus();
						},
						
				})
		$('#new_playlist').blur();
			Popup.close();
		
			return false;
		}", CClientScript::POS_END );

$urlCreatePlaylist = Yii::app ()->createUrl ( '/song/addNewPlaylist', array('songId'=>$songId));
//$liItem = '<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-last-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text"><a href="/song/addToPlaylist?pid=1134" class="addPlaylist ui-link-inherit">sdtad asdfsdfs s</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
$cs->registerScript ( 'add-new-playlist', "$('#sb_playlist').on('click', function(){

			if(!userPhone){
				alert(msgDetect);
				return false;
			}
			var name = $('#new_playlist').val();
			$('#new_playlist').blur();
			var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
			      var hashArray = hash.split('_');
				
			      var id = hashArray[1];
					if(id == 0 || id == 'undefined')
					{
						id = $('#detail_songid').val();
					}
			if($.trim(name)==''){
                                alert(__t('The playlist title cannot be blank'));
                                $('#new_playlist').focus();
				return false;
			}
				$.ajax({
				url:'" . $urlCreatePlaylist . "',
				data: {name:name},
				success: function(data){
				if(data =='1')
                                    {
                                        alert(__t('Playlist title already exists'));
                                        $('#new_playlist').focus();
                                        return false;
                                    }
		if (data =='2')
		{
                    var html = '<li><a onclick=\"addToPlaylist(\'/song/addToPlaylist?pid='+data+'\')\" href=\"javascript:void(0);\" class=\"addPlaylist\">'+name+'</a></li>';
                    $('#myplaylist').append(html);
                    $('#new_playlist').val('');
                    Popup.close();
                    $('#sb_playlist').focus();
                    alert(__t('successfully added to playlist'));
		}
                else if (data =='3')
		{
                alert(__t('The playlist title is no more than 30 characters'));
                    return false;
		}
                else if (data =='4')
		{
                alert(__t('Playlist title must not include any special character'));
                    return false;
		}
		else
		{
                    alert(__t('An error occurred while processing. Please try again later.'));
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
			//$("#popupPlaylist").popup("open");
			$("#new_playlist").blur();
		 };', CClientScript::POS_END );
$cs->registerScript ( 'add_song_to_playlist', 'function add_song_to_playlist(){
			if(!userPhone){
				alert(msgDetect);
				return false;
			}
		 	//$("#popupPlaylist").popup("open");
			$("#new_playlist").blur();
	 	 };', CClientScript::POS_END );

?>
<?php endif;?>