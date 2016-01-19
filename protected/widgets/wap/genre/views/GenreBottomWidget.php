<?php if(!$special):?>
<div class="block_list clb">
	<div class="fontB bl_title">
		<a href="<?php echo Yii::app()->createUrl("genre/index",array("type"=>$type))?>"><?php echo mb_strtoupper('Thể loại', 'UTF-8');?></a>
	</div>
    <div class="bl_item">
    	<table class="genretb">
            <?php
            $i=0;
            foreach($genres as $genre):
                $genreLink = URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$genre->name,'id'=>$genre->id));
			/*if($genre->parent_id == 0)
				$genreLink = Yii::app()->homeUrl. 'genre#'.$genre->id;*/
            if($i%2==0) echo '<tr>';
            
            $hot = $new = '';
            $baseUrl = Yii::app()->request->baseUrl;
            if($genre->is_hot)
                $hot = "<img style='margin-left: 6px;' src='" .$baseUrl ."/wap/images/hot.gif' />";
            if($genre->is_new)
                $new = "<img style='margin-left: 6px;' src='" .$baseUrl ."/wap/images/new.gif' />";
            ?>
            <td class="wid50">
                <a class="<?php echo ($genre_id  == $genre->id)?  'active' : '';?>" href="<?php echo $genreLink;?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/wap/images/genre_icon.png" /><?php echo $genre->name.$hot.$new; ?></a>
            </td>
            <?php 
            if($i%2==1) echo '</tr>';
            $i++;
            endforeach; ?>
            
        </table>
        <a class="vg_more flr cl6" href="<?php echo Yii::app()->createUrl("genre/index",array("type"=>$type))?>">Xem thêm &raquo;</a>
    </div>
</div>
<?php else:?>
<div class="block_list clb">
	<div class="headline fontB"><?php echo mb_strtoupper('Thể loại', 'UTF-8'); ?></div>
    <div class="bl_item">
    	<table class="genretb">
            <?php
            $i=0;
            foreach($genres as $genre):
                $genreLink = yii::app()->createUrl($special.'/index', array('g' => $genre->id));
			
            if($i%2==0) echo '<tr>';
            
            $currentGid = Yii::app()->request->getParam('g');
            $style = ($genre->id == $currentGid)?'font-weight:bold':'';
            ?>
            <td class="wid50">
                <a href="<?php echo $genreLink;?>" style="<?php echo $style?>"><img src="/wap/images/icon_song.png" /><?php echo $genre->name; ?></a>
            </td>
            <?php 
            if($i%2==1) echo '</tr>';
            $i++;
            endforeach; ?>
            
        </table>
    </div>
</div>
<?php endif;?>