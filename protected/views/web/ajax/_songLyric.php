    <div class="lyrics box">
        <h3><?php echo Yii::t('web', 'Lyric') ?>: <?php echo CHtml::encode($song->name)?></h3>
        <div class="content_lyrics">
            <p class="lyric" id="lyric_box">
                <?php
                $flag = true;
                if (!isset ( $songExtra ) && empty($songExtra->lyrics)) {
                    $flag = false;
                    echo Yii::t('web', 'Lời bài hát đang được cập nhật');
                } else {
                    $flag = true;
                    $p = new CHtmlPurifier();
                    $p->options = array('HTML.ForbiddenElements' => array('p', 'span','a','script'));
                    $content = $p->purify($songExtra->lyrics);
                    echo nl2br($content);
                }
                ?>
            </p>
        </div>
        <?php if ($flag): ?>
            <a class="fs11 more" id="lyric_more" href="javascript:void(0)"><?php echo Yii::t('web', 'View all');?> <i class="icon icon_mt"></i></a>
            <a class="fs11 more" id="lyric_short" href="javascript:void(0)" style="display: none;"><?php echo Yii::t('web', 'Collapse');?> <i class="icon icon_mt"></i></a>
        <?php endif; ?>
    </div>

