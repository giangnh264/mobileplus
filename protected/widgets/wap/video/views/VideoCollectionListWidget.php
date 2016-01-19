<table class="videolist tablelist">
    <?php
    $currentPage = Yii::app()->request->getParam('pv', 1);
    $number = ($currentPage - 1) * yii::app()->params['pageSize'] + 1;
    foreach ($videos as $video) :
    	if ($video->id != $excludeId) :
		    $videoLink = yii::app()->createUrl('video/view', array('id' => $video->id, 'url_key' => Common::makeFriendlyUrl($video->name), 'src' => $src, 'playlist' => ($playlist) ? $playlist : 0));
			if ($video->id) {
		            $avatarImage = CHtml::image(WapVideoModel::model()->getThumbnailUrl(100, $video->id), 'avatar', array('class' => 'avatar'));
		        } else {
		            $avatarImage = CHtml::image('/css/wap/images/icon/clip-50.png', 'avatar', array('class' => 'avatar'));
		        }
			?>
			<tr><td width="100px" onclick="document.location = '<?php echo $videoLink ?>'">              
					<?php					
						echo $avatarImage;					
					?>
				</td>
		        
		        <td class="itemwrap" onclick="document.location = '<?php echo $videoLink ?>'">
		            <p class="m0 fontB">
		                <a href="<?php echo $videoLink ?>"><?php echo WapCommonFunctions::substring($video->name, ' ', 6);?></a>
		            </p>
		
		            <p class="m0 artistname">					
		                   <span><?php echo WapCommonFunctions::substring($video->artist_name, ' ', 6) ?></span>
		            </p>
		        </td>
		    </tr>
	<?php
		endif; 
		endforeach 
	?>
</table>
