<?php
$rbts = $total_results['rbt']['results'];
?>
<?php
foreach($rbts as $rbt):
$link = Yii::app()->createUrl('/ajax/getPopupRbt', array('rbt_id'=>$rbt['id']));
?>
    <li class="item">
	 		<a href="javascript:void(0);" onclick="Popup.ajax('<?php echo $link;?>');">
		 		<i class="vg_icon icon_song"></i>
		 		<h3><?php echo CHtml::encode($rbt['name'])?></h3>
		 		<ul class="info">
	            	<li><i class="vg_icon icon_artist"></i><?php echo CHtml::encode($rbt['artist'])?></li>
	            </ul>
        	</a>
    </li>
<?php endforeach;?>