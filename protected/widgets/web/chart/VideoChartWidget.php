<?php
class VideoChartWidget extends CWidget{
    public $code='BXH_VIDEO_VN';
    public $genre=null;
    public function init()
    {
        $cs=Yii::app()->getClientScript();
        $cs->registerScript('load_video_rank',"
            $('#chart_video .ajax_load li a').live('click',function(){
                var rel = $(this).attr('rel');
                 $.ajax({
                    url: '/ajax',
                    type: 'POST',
                    data: {action:'chart', _type:'video',genre:rel},
                    beforeSend: function(){
                        $('#chart_video').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
                    },
                    success: function(data){
                        $('#chart_video').html(data);
                    }
                 })
            })
        ");
        parent::init();
    }
    public function run()
    {
        $genre = empty($this->genre)?'VN':$this->genre;
        $limit = Yii::app()->params['limit_chart_home_number'];
        if (!empty($this->code)) {
            $code = $this->code;
        } else {
            $collection = CollectionModel::model()->getCollectionByType('video', 'bxh', $genre, 0);
            $collection = ($collection) ? $collection[0] : null;
            $code = ($collection) ? $collection->code : 'BXH_VIDEO_'.strtoupper($genre);
        }
        $collection = CollectionModel::model()->getCollectionByType('video', "bxh", $genre, 0);
        $collection = ($collection) ? $collection[0] : null;
        $collectionCode = ($collection) ? $collection->code : $code;


        $data = MainContentModel::getListByCollection($collectionCode, 1, $limit);
        $this->render('video', compact("data","code","limit"));
    }
}