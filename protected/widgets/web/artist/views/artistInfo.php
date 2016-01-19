<div class="box_title">
    <h2 class="name"><?php echo Yii::t('web', 'History'); ?> <?php echo $this->artistDetail->name;?></span></h2>
</div>

<p class="pt20">
    <?php
        if(!empty($this->artistDetail->description)) {
            /*$p = new CHtmlPurifier();
            $p->options = array('HTML.ForbiddenElements' => array('p', 'span'));
            $content = $p->purify($this->artistDetail->description);*/
            $p = new CHtmlPurifier();
            $p->options = array('HTML.ForbiddenElements' => array('p', 'span','a','script'));
            $content = $p->purify($this->artistDetail->description);
            $content = nl2br($content);
            echo $content;
        }
    ?>
</p>