<div class="topcontent-list-widget <?php //echo $this->class;?>">
    <?php if($topContent):?>
        <div class="box_title">
            <h2 class="name"><a href="<?php echo $this->link;?>" title="<?php echo $title;?>"><?php echo $title; ?></a></h2>
        </div>
        <div class="box_content">
            <ul class="items-list">
                <?php
                $i=0;
                foreach($topContent as $item){
                    if($i%2==0){
                        echo '<li class="item-row">';
                    }
                        $link = Yii::app()->createUrl("topContent/view",array("id"=>$item['id'],"title"=>Common::makeFriendlyUrl($item['name'])));
                        $thumb = TopContentModel::model()->getAvatarUrl($item['id']);
                    ?>
                    <div class="item-cell cell-<?php echo $i%2?>">
                        <div class="wrr-item-cell">
                            <div class="wrr-main-cell thumb-hover ">
                                <a href="<?php echo $link;?>"><img class="thumb_topcontent" width="100%" src="<?php echo $thumb;?>" /></a>
                                <a href="<?php echo $link;?>"><div class="bg_fake"></div></a>
                                <h3 class="name over-text"><a class="title" href="<?php echo $link ?>" title="<?php echo CHtml::encode($item['name']);?>"><?php echo CHtml::encode($item['name']);?></a></h3>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                    if($i%2==0 && $i!=0){
                        echo "</li>";
                    }
                }?>
            </ul>
        </div>
    <?php endif;?>
</div>