<!-- display artist list page -->
<div class="headline">
    <?php echo Yii::t('chachawap', 'Top nghệ sỹ') ?>
</div>
<!-- artist list -->
<?php $this->widget('application.widgets.wap.artist.ArtistList', array('artists' => $artists, 'artistPages' => $artistPages)) ?>
<!-- end aritst list -->
