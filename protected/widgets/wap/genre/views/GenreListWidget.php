<div class="clb">
	<div class="headline fontB bl_title">
		<a href="<?php echo Yii::app()->createUrl("genre/index",array("type"=>$type))?>"><?php echo mb_strtoupper('Thể loại', 'UTF-8');?></a>
	</div>
    <div class="bl_item">
    	<ul class="ul0 vg_tl">
            <?php
            foreach($parentGenres as $pGenres):
            	$hot = $new = "";
            ?>
                <li class="wid100  parentgenre">
                    <?php 
                    
                    $genreLink = URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$pGenres->name,'id'=>$pGenres->id));?>
                    <a href="<?php echo $genreLink;?>" id="<?php echo $pGenres->id?>"><?php echo $pGenres->name.$hot.$new; ?></a>
                </li>
                <?php
                $pid = $pGenres->id;
                $subGenres = $arrSubGenres[$pid];
                if(!empty($subGenres) && count($subGenres)>0):
                ?>
                <ul class="ul0 vg_tl subgenrelist">
                    <?php
                    foreach($subGenres as $pGenres):
                        //$genreLink = yii::app()->createUrl('genre/detail', array('id' => $pGenres->id, 'type' => $type));
                        $genreLink = URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$pGenres->name,'id'=>$pGenres->id));
                        $hot = $new = '';
                        if($pGenres->is_hot)
                            $hot = "<img style='margin-left: 6px;' src='/wap/images/hot.gif' />";
                        if($pGenres->is_new)
                            $new = "<img style='margin-left: 6px;' src='/wap/images/new.gif' />";
                    ?>
                    <li class="wid100 ">
                        <a href="<?php echo $genreLink;?>"><?php echo $pGenres->name.$hot.$new; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                endif;
            endforeach; ?>
        </ul>
    </div>
</div>