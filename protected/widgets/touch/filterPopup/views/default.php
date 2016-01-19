
<a class="i-title-select <?php echo $type == "status"?  "pop-up-status": "";?>" onclick="javascript:onSuccess_<?php echo $type;?>();" ><?php echo $title_actived = ($title_actived=='NEW')?"MỚI":$title_actived;?></a>
<div class="i-popup" data-role="popup" id="popupNested_<?php echo $type;?>" data-theme="e" data-overlay-theme="a">

    <div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
   		<?php if($type=='category'):?>

   		<div data-role="header" data-theme="a" class="ui-corner-top">
        	<h1>THỂ LOẠI</h1>
        	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="i-close ui-btn-right" style="position: absolute;">Close</a>
   		</div>
   		<?php foreach ($genreRoot as $key => $item):?>
   		<div data-inset="false">
            <h2><?php echo $item->name;?></h2>
            <ul data-role="listview">
            	<?php foreach ($genresAll as $key1 => $genre):?>
            	<?php if($genre->parent_id==$item->id):
            		$s = isset($_GET['s'])?$_GET['s']:'';
            		$genreLink = Yii::app()->createUrl("$route", array('c'=>$genre->id, 's'=>$s));
            	?>
            		<li><a href="<?php echo CHtml::encode($genreLink); ?>" ><?php echo $genre->name;?></a></li>
            	<?php endif;?>

                <?php endforeach;?>
            </ul>
        </div><!-- /collapsible -->
   		<?php endforeach;?>


        <?php
        	elseif($type=='status'):

        	$c = isset($_GET['c'])?$_GET['c']:'0';
        	$c = CHtml::encode($c);
        ?>
	        <div data-role="header" data-theme="a" class="ui-corner-top">
	        	<h1>KIỂU</h1>
	        	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right" style="position: absolute;">Close</a>
	   		</div>
	        <div  data-inset="false">
	            <ul data-role="listview">
	            <?php if ($route =='bxh/index' ):?>
	             <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'SONG'));?>" >BÀI HÁT</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'VIDEO'));?>" >VIDEO</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'ALBUM'));?>" >PLAYLIST</a></li>
	                <?php   elseif ($route =='favourite/index' ):?>
	             <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'SONG'));?>" >BÀI HÁT</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'VIDEO'));?>" >VIDEO</a></li>
	            <?php else:?>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'NEW'));?>" >MỚI</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('c'=>$c, 's'=>'HOT'));?>" >HOT</a></li>
	                <?php endif;?>
	            </ul>
	        </div><!-- /collapsible -->
	        <?php
        	elseif($type=='bxh'):
        	$s = isset($_GET['s'])?$_GET['s']:'SONG';
        	$s  = CHtml::encode($s );
        ?>
         <div data-role="header" data-theme="a" class="ui-corner-top">
	        	<h1>BẢNG XẾP HẠNG</h1>
	        	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right" style="position: absolute;">Close</a>
	   		</div>
	        <div  data-inset="false">
	            <ul data-role="listview">
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('s'=>$s, 'c'=>'VIETNAM'));?>" >VIỆT NAM</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('s'=>$s, 'c'=>'QUOCTE'));?>" >ÂU-MỸ</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('s'=>$s, 'c'=>'HANQUOC'));?>" >HÀN QUỐC</a></li>

	            </ul>
	        </div><!-- /collapsible -->

	        <?php elseif($type=='search'):
	        $keyword = CHtml::encode(Yii::app()->request->getParam('content'));
        	?>
         <div data-role="header" data-theme="a" class="ui-corner-top">
	        	<h1>TÌM KIẾM THEO</h1>
	        	<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right" style="position: absolute;">Close</a>
	   		</div>
	        <div  data-inset="false">
	            <ul data-role="listview">
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('content'=>$keyword, 'type'=>'song'));?>" >BÀI HÁT</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('content'=>$keyword, 'type'=>'clip'));?>" >VIDEO</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('content'=>$keyword, 'type'=>'album'));?>" >PLAYLIST</a></li>
	                <li><a href="<?php echo Yii::app()->createUrl("$route", array('content'=>$keyword, 'type'=>'rbt'));?>" >NHẠC CHỜ</a></li>
	            </ul>
	        </div><!-- /collapsible -->

        <?php endif;?>
    </div><!-- /collapsible set -->
</div><!-- /popup -->

<script type="text/javascript">
 function onSuccess_<?php echo $type;?>(){
      $('#popupNested_<?php echo $type;?>').popup('open');
 }    ;

</script>