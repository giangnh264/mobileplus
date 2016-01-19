<?php if ($radios) :?>
<table class="tablelist">
    <?php
    foreach ($radios as $radio) :
	$avatar = RadioModel::model()->getAvatarUrl($radio['id'],'s2');
    $link = Yii::app()->createUrl('/horoscopes/view', array('id'=>$radio['id'], 'url_key'=>Common::url_friendly($radio['name'])));
    ?>
	<tr>
		<td width="65px">
			<a href="<?php echo $link ?>">
	            <img alt="avatar" src="<?php echo $avatar;?>" class="avatar">
	        </a>
		</td>
        <td class="itemwrap" >
            <p class="m0 fontB">
                <a href="<?php echo $link ?>"><?php echo WapCommonFunctions::substring($radio['name'], ' ', 6);?></a>
            </p>
            <p class="m0 artistname">
	            <a href="<?php echo $link ?>">
	            	<span>
	            		<?php echo CHtml::encode($radio['album_name']) ; ?>
	            	</span>            
	            </a>
            </p>
        </td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif;?>

<?php
if ($type == "home_page"): ?>
	<a class='vg_more flr cl6' href="<?php echo Yii::app()->createUrl('/horoscopes/list')?>" >Xem thêm &raquo;</a>
<?php endif; ?>