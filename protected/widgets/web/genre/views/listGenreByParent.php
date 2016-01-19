<?php
$genreAll  = WebGenreModel::model()->getGenreAll();
?>
<?php foreach($genreAll as $genreList):?>
    <?php if($genreList['parent_id'] ==0):?>
    <div class="box">
        <div class="box_title_genre">
            <?php $parentLink = Yii::app ()->createUrl($type."/index", array ("id" => $genreList['id'], "title" => Common::makeFriendlyUrl(trim($genreList['name'])))); ?>
            <h2 class="name"><a href="<?php echo $parentLink;?>" <?php echo ($curGenre == $genreList['id']) ? 'class="active_color"': ""; ?>><?php echo $genreList['name']; ?></a></h2>
        </div>
            <ul class="list_cat">
                <?php foreach($genreAll as $genreChlid):
                    if($genreChlid['parent_id'] ===$genreList['id']):
                    $link = Yii::app ()->createUrl($type."/index", array ("id" => $genreChlid['id'], "title" => Common::makeFriendlyUrl(trim($genreChlid['name']))));
                    ?>
                    <li><a href="<?php echo $link;?>" <?php echo ($curGenre == $genreChlid['id']) ? 'class="active_color"': ""; ?>><?php echo Yii::t('web',$genreChlid['name'])?></a></li>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
    </div>
    <?php endif;?>
<?php endforeach;?>
