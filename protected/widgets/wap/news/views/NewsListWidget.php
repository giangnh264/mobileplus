<table class="bg_news mylistnew tablelist">    
    <?php
    if (isset($albumPages))
        $number = $albumPages->getCurrentPage() * yii::app()->params['pageSize'] + 1;
    else
        $number = 1;
    foreach ($newsList as $news) :
        echo '<tr>';
        $newsLink = yii::app()->createUrl('news/view', array('id' => $news->id, 'url_key' => Common::makeFriendlyUrl($news->title)));
        $thumbnailUrl = WapNewsModel::model()->getThumbnailUrl(100, $news->id);
        
        /*
         * $agetHeaders = @get_headers($thumbnailUrl);
        if (preg_match("|200|", $agetHeaders[0])) {
            $avatarImage = CHtml::image($thumbnailUrl, 'avatar');
        } else {
            $avatarImage = CHtml::image('../css/wap/images/icon/default-50.png', 'avatar');
        }
         */
        $avatarImage = CHtml::image($thumbnailUrl, 'avatar');
        if (($type == "homepage" && $number == 1) || ($type != "homepage")):
            ?>
            <td onclick="document.location = '<?php echo $newsLink ?>'">
                <table>
                    <tr style="background: none">
                        <td width="85px"><?php echo $avatarImage ?></td>
                        <td>
                            <a class="m0 fontB" style="padding-left:0" href="<?php echo $newsLink ?>">
                                <?php
                                echo WapCommonFunctions::substring($news->title, ' ', 10);            
                                ?>
                               
                            </a>
                            <span class="time cl6 padB10 ">(<?php
                                $date = date('d/m H:i', strtotime($news->created_time));
                                echo $date;
                               ?>)
                            </span>
                        </td>
                    </tr>
                    <tr>
                    	<td colspan="2" >
                       		<p class="m0 cl6 smallText padB10"><?php echo $news->intro ?></p>
                       </td>
                    </tr>
                </table>   
            </td>
        <?php else: ?>
            <td>
                <a class="m0 fontB" href="<?php echo $newsLink ?>">
                    <?php
                    echo WapCommonFunctions::substring($news->title, ' ', 10);            
                    ?>
                </a>
                <span class="time cl6 padB10">(<?php
                    $date = date('d/m H:i', strtotime($news->created_time));
                    echo $date;
                    ?>)</span>
            </td>
        <?php
        endif;
        $number++;
        echo '</tr>';
    endforeach
    ?>
</table>

<?php
if ($type == "homepage"):
    echo "<a class='vg_more flr cl6' href='". Yii::app()->createUrl("/news") ."' >Xem thêm &raquo;</a>";
else:
    ?>
    <div class="padding clb">
        <center>
            <?php
            $this->widget('application.widgets.wap.common.Paging', array('pages' => $newsPages));            
            ?>
        </center>
    </div>
<?php
endif;
?>