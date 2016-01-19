<?php foreach($songs as $song):
	$artist_name = Common::makeFriendlyUrl($song->artist_name);
$link = Yii::app()->createUrl("song/view",array("id"=>$song['id'],"title"=>Common::makeFriendlyUrl(CHtml::encode($song['name'])), 'artist'=>$artist_name))
?>
<li>
	<a href="<?php echo $link ?>" title="<?php echo CHtml::encode($song['name']) . ' - ' . CHtml::encode($song['artist_name']); ?>"><img src="<?php echo AvatarHelper::getAvatar("artist", $song['artist_id'],50)?>" alt="<?php echo $song['name']?>" width="50" height="50" /></a>
	<h3><a href="<?php echo $link ?>" class="song_name"><?php echo Formatter::smartCut(CHtml::encode($song['name']),24)?></a></h3>
	<?php $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("q"=>CHtml::encode(CHtml::encode($song['artist_name']))));?>
	<h4 class="song_aritis"><a href="<?php echo $linkArtist;?>" title="<?php echo CHtml::encode($song['artist_name']) ?>"><?php echo Formatter::smartCut(CHtml::encode($song['artist_name']),25)?></a></h4>
</li>
<?php endforeach;?>