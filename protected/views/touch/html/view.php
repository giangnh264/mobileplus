<div class="collapse-10">
    <div class='list-label mr-t-15 clearfix'>
        <a href='#' class='head left'><?php echo $guide->title ?></a>
    </div>
</div>

<?php if($guide->channel=='api'):?>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
    </style>
    <?php echo $guide->content ?>
<?php else:?>
    <div class="padB10"><?php echo $guide->content ?></div>
<?php endif;?>
<div id="dd" style="display: none;">
    <div id="Popup">
        <a href="javascript:void(0)" class="popup_close">X</a>
        <div id="popup_wr">
            <div class="popup_title">
                <span id="pop_title">Hướng dẫn</span>
            </div>
            <div class="popup_content">
                <ul class="list_genre">
                    <?php foreach ($wapGuides as $wapGuide) :?>
                        <li><a href="<?php echo yii::app()->createUrl('/account/guide', array('id'=>$wapGuide->id)) ?>" class="clblue"><?php echo $wapGuide->title ?></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>