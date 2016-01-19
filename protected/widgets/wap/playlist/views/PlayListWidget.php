<table class="playlist tablelist">
    <?php
    $currentPage = Yii::app()->request->getParam('ps', 1);
    $number = ($currentPage - 1) * yii::app()->params['pageSize'] + 1;
    foreach ($playlists as $playlist) :
	$playlistLink = yii::app()->createUrl('playlist/detail', array('id' => $playlist->id, 'baseid' => NULL, 'url_key' => Common::makeFriendlyUrl($playlist->name), array('class' => 'avatar')));
	if ($playlist->id) {
		$avatarImage = CHtml::image(UserModel::model()->getThumbnailUrl(50, $playlist->user_id), 'avatar', array('class' => 'avatar'));
	} else {
		$avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar');
	}
	?>
	<tr><td width="65px">              
			<?php
				echo $avatarImage;			
			?>
		</td>        
        <td class="itemwrap" onclick="document.location = '<?php echo $playlistLink ?>'">
            <p class="m0 fontB">
                <a href="<?php echo $playlistLink ?>"><?php echo WapCommonFunctions::substring($playlist->name, ' ', 6);?></a>
            </p>
			
            <p class="m0 artistname">					
			<?php if ($type != "myplaylist"): ?>
                   <span><?php 
                   $usname = WapCommonFunctions::substring($playlist->username, ' ', 6);

					if (strlen($usname) > 20) {
						$usname = substr($usname, 0, 20);
						echo $usname . "...";
					}
					else
						echo $usname;
                   ?></span>
			<?php endif; ?>
            <img class="statistic_icon" alt="nghe" src="/css/wap/images/new/nghe.png">
            <?php
                if (isset($playlist->playlist_statistic[0]))
                    $playlist->playlist_statistic = $playlist->playlist_statistic[0];
                if (isset($playlist->playlist_statistic) && !empty($playlist->playlist_statistic->played_count)) {
                    echo $playlist->playlist_statistic->played_count;
                } else
                    echo "0";
            ?>
            </p>
        </td>	
	</tr>
	<?php endforeach ?>
</table>
<?php
if ($type == "homepage" || $type == 'myplaylist'):
    if($playlists && count($playlists) > 0):
        if (empty($link))
            $link = "playlist";
        echo "<a class='vg_more flr cl6' href='/$link' >Xem thêm &raquo;</a>";
    endif;
else:
    ?>
    <div class="padding clb">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $playlistPages));
            
            ?>
        </center>
    </div>
<?php
endif;
?>