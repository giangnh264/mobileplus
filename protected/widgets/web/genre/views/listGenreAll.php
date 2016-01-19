<div class="cat-fullbox">
    <?php $k = 0; foreach ($genres as $genre): ?>
        <div class="cat-div" <?php if($this->columPercentWidths[$k]) echo 'style="width: '.$this->columPercentWidths[$k].'% !important;"';?>>
            <div class="clb">
                <div class="cat-title">	
                <?php if((empty($this->selectedGenreId) || $this->selectedGenreId<=0) && $k==count($genres)-1):?>
                	<h1><?php echo Yii::t('web', $genre['name']); ?></h1>
                <?php else:?>
                    <h3><?php echo Yii::t('web', $genre['name']); ?></h3>
                <?php endif?>
                </div>
            </div>
            <div class="cat-sub">
                <ul>
                    <?php
                    $max = count($genre['data']);
                    $i = 0;
                    while ($i < $max) {?>  					
                        <?php
                        if (isset($genre['data'][$i])) :
                            $link = Yii::app()->createUrl($this->type . "/index", array("id" => $genre['data'][$i]['id'], "title" => trim($genre['data'][$i]['url_key'], "-")));
                            ?>
                            <li class="<?php echo $k;?>" style="<?php echo 'width: '; if($i%2==1) echo $this->subPercentWidths[$k*2+1]; else echo $this->subPercentWidths[$k*2]; echo '% !important';?>">
                                <h3>
                                    <a  title="<?php echo CHtml::encode($genre['data'][$i]->name);?>"
                                        href="<?php echo $link; ?>" 
                                        class="<?php echo ($this->selectedGenreId && $genre['data'][$i]['id'] == $this->selectedGenreId)? 'active' : ''?>">
                                        <?php echo Formatter::smartCut(CHtml::encode($genre['data'][$i]->name),30); ?>
                                    </a>
                                </h3>
                            </li>					
                        
                        <?php endif; ?>
                        <?php $i++;
                    };?>
                    <?php $emptyRows = ($maxRow-$max>0)?($maxRow-$max):0;
                        for($j=0; $j<$emptyRows; $j++):?>
                            
                    <?php endfor;?>
                </ul>
            </div>
        </div>
    <?php $k++; endforeach; ?>	
</div>