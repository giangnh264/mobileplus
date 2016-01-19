<?php
class AlbumChartWidget extends CWidget{
    public $code='BXH_ALBUM_VN';
    public $genre = null;
    public function init()
    {
        $cs=Yii::app()->getClientScript();
        $cs->registerScript('load_album_rank',"
            $('#chart_album .ajax_load li a').live('click',function(){
                var rel = $(this).attr('rel');
                 $.ajax({
                    url: '/ajax',
                    type: 'POST',
                    data: {action:'chart', _type:'album',genre:rel},
                    beforeSend: function(){
                        $('#chart_album').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
                    },
                    success: function(data){
                        $('#chart_album').html(data);
                    }
                 })
            })
        ");
        parent::init();
    }
    public function run()
    {
        $limit = Yii::app()->params['limit_chart_home_number'];
        $genre = empty($this->genre)?'VN':$this->genre;
        if (!empty($this->code)) {
            $code = $this->code;
        }
        $collection = CollectionModel::model()->getCollectionByType('album', "bxh", $genre, 0);
        $collection = ($collection) ? $collection[0] : null;
        $code = ($collection) ? $collection->code : $code;

        $data = MainContentModel::getListByCollection($code, 1, $limit);

        $this->render('album', compact("data","code","limit"));
    }
}