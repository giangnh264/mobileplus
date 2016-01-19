<div class="home_slide" style="margin-bottom: 10px;" >
    <?php
    $newsEvent = NewsEventModel::model()->getEventByChannel('web');
    $data = array();
    $i = 0;
    foreach ($newsEvent as $value) {
        $data[$i]['avatar'] = AvatarHelper::getAvatar('newsEvent', $value->id, 's1');
        $data[$i]['link'] = NewsEventModel::model()->getEventLink($value);
        $data[$i]['title'] = $value->name;
        $data[$i]['desc'] = '';
        $i++;
    }
    $this->widget('application.widgets.touch.sls.SlideshowWidget', array('data' => $data));
    ?>
</div>