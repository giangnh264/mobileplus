<div id="Popup">
<a href="javascript:void(0)" class="popup_close">X</a>
	<div id="popup_wr">
	<div class="popup_title">
		<span id="pop_title"><?php echo Yii::t("wap","Thể loại");?></span>
	</div>
        <?php
            $s = isset($_GET['s'])?$_GET['s']:'';
            $s = strtolower($s);
            $type = '';
            switch($route){
                    case '/album/list':
                            $type = 'album';
                            break;
                    case '/video/list';
                            $type = 'video';
                            break;
                    default :
                        $type = 'song';
                        break;
                            
            }
	?>
	<div class="popup_content">
		<ul class="list_genre">
       		<li><a class="p-title" href="<?php echo URLHelper::makeUrlGenre(array("type"=>$type,'name'=>Yii::t('wap','Tất cả thể loại'),'id'=>0,'gt'=>$s)); ?>"><?php echo Formatter::smartCut(CHtml::encode( Yii::t("wap","Tất cả thể loại")), 20, 0);?></a></li>
		<?php foreach ($genreRoot as $key => $item):?>
			<li><p class="p-title"><a href="<?php echo URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$item->name,'id'=>$item->id,'gt'=>$s));?>"><?php echo $item->name;?></a></p>
			<ul class="sub_list_genre">
			<?php foreach ($genresAll as $key1 => $genre):?>
				<?php if($genre->parent_id==$item->id):
					$genreLink = URLHelper::makeUrlGenre(array("type"=>$type,'name'=>$genre->name,'id'=>$genre->id,'gt'=>$s));
            	?>
            		<li><a href="<?php echo CHtml::encode($genreLink); ?>"><i class="vg_icon icon_liii"></i><?php echo Formatter::smartCut(CHtml::encode($genre->name), 20, 0);?></a></li>
            	<?php endif;?>
			<?php endforeach;?>
			</ul>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
	</div>
</div>
