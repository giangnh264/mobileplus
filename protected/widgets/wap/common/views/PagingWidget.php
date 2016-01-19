<?php
if($current_paging)
    $this->widget('CLinkPager', array('pages' => $pages,
        'maxButtonCount' => Yii :: app()->params['pager.max.button.count'], 
        'header' => '', 
        'nextPageLabel' => 'Sau &rsaquo;', 
        'prevPageLabel' => '&lsaquo; Trước', 
        'firstPageLabel' => '&laquo; Đầu', 
        'lastPageLabel' => 'Cuối &raquo;',
        'currentPage' => intval($current_paging) - 1
    ));
else    
    $this->widget('CLinkPager', array('pages' => $pages,
        'maxButtonCount' => Yii :: app()->params['pager.max.button.count'], 
        'header' => '', 
        'nextPageLabel' => 'Sau &rsaquo;', 
        'prevPageLabel' => '&lsaquo; Trước', 
        'firstPageLabel' => '&laquo; Đầu', 
        'lastPageLabel' => 'Cuối &raquo;',
    ));
?>
