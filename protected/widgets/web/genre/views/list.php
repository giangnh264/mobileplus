<div class="genre">
	<div class="genre-all-genre">
		<h2><?php echo Yii::t('web','All genres'); ?></h2>
	</div>
	<ul class="sub">
		<li>
			<?php
			$i = 0;
			foreach ( $genres as $genre ) {
				$link = "";
				if ($this->type == "song") {
					$link = Yii::app ()->createUrl("song/index", array ("id" => $genre ['id'], "title" => trim ( $genre ['url_key'], "-" )));
				} else if ($this->type == "album") {
					$link = Yii::app ()->createUrl("album/index", array("id" => $genre ['id'], "title" => trim ( $genre ['url_key'], "-" )));
				} else if ($this->type == "video") {
					$link = Yii::app ()->createUrl ( "video/index", array ("id" => $genre ['id'], "title" => trim ( $genre ['url_key'], "-" )));
				} else if ($this->type == "artist") {
					$link = Yii::app ()->createUrl ( "artist/index", array ("id" => $genre ['id'], "title" => trim ( $genre ['url_key'], "-" )));
				}
			
			
				if ($genre ['parent_id'] == 0) {
					if ($genre ['parent_id'] == 0 && $i > 0) {
						echo '</ul>';
						$i = 0;
					}
					
					echo '<h2>'.CHtml::encode ( $genre ['real_name'] ).'</h2>';
					if ($genre ['parent_id'] == 0 && $i == 0) {
						echo '<ul class="sub_genre">';
					}
					$i++ ;
				} else {
					$class = ($curGenre == $genre['id']) ? 'class="coban_color"' : '';
					echo '<li><h3><a ' . $class . ' href="' . $link . '">'. $genre ['real_name'] . '</a></h3></li>';				
				}
			}
			echo '</ul>';
			?>
			
		</li>
	</ul>
</div>