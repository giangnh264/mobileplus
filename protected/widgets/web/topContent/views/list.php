<?php if($topContent):?>
<div class="box_title">
    <a href="<?php echo Yii::app()->createUrl("topContent");?>">
        <h2 class="name fs24"><?php echo Yii::t('web','Music Collection'); ?></h2>
    </a>
</div>
<div class="box_content">
    <ul class="collection_list">
        <?php foreach($topContent as $item):
            if($item->id != $curentId):
                $link = Yii::app()->createUrl("topContent/view",array("id"=>$item->id,"title"=>Common::makeFriendlyUrl($item->name)));
        ?>
            <?php if(isset($item)):?>
                <li><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($item->name);?>"><?php echo Formatter::smartCut(CHtml::encode($item->name),30);?></a></li>
            <?php endif;?>
            <?php endif;?>
    <?php endforeach;?>
    </ul>
</div>
<?php endif;?>