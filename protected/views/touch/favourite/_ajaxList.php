<?php
if($songs):
	foreach($songs as $song):
        $artist_name = Common::makeFriendlyUrl($song->artist_name);
		$link = Yii::app()->createUrl('song/view', array('id' => $song->id, 'url_key' => Common::makeFriendlyUrl($song->name), 'artist'=>$artist_name));
		?>
<li class="item">
	    <a href="<?php echo $link;?>">
		 		<i class="vg_icon icon_song"></i>
		 		<h3><?php echo CHtml::encode($song->name)?></h3>
		 		<ul class="info">
	            	<li><i class="vg_icon icon_artist"></i>
	            	<?php
                        $artists = explode(',', $song->artist_name);
                        $count = count($artists);
                        $i = 1;
                        foreach ($artists as $artist) {
                            $artist = trim($artist);
                            echo $artist;
                            if ($i < $count)
                                echo "&nbsp;-&nbsp;";
                            $i++;
                        }
                    ?>
	            	</li>
	            </ul>
		</a>
</li>
		
<?php endforeach;?>
<?php else:?>
<li>Không có bài hát nào</li>
<?php endif;?>