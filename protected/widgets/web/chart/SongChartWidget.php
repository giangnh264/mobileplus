<?php
class SongChartWidget extends CWidget{
    public $code=null;
    public $genre=null;
    public function init()
    {
        $cs=Yii::app()->getClientScript();
        $cs->registerScript('load_song_rank',"
            $('#chart_song .ajax_load li a').live('click',function(){
                var rel = $(this).attr('rel');
                 $.ajax({
                    url: '/ajax',
                    type: 'POST',
                    data: {action:'chart', _type:'song',genre:rel},
                    beforeSend: function(){
                        $('#chart_song').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
                    },
                    success: function(data){
                        $('#chart_song').html(data);
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
        } else {
            $collection = CollectionModel::model()->getCollectionByType('song', 'bxh', $genre, 0);
            $collection = ($collection) ? $collection[0] : null;
            $code = ($collection) ? $collection->code : 'BXH_SONG_'.strtoupper($genre);
        }

        $data = MainContentModel::getListByCollection($code, 1, $limit);
        $crit = new CDbCriteria();
        $crit->condition = 'code=:code';
        $crit->params = array(':code'=>$code);
        $collection = WebCollectionModel::model()->find($crit);
        $this->render('song', compact("data","code","collection","genre"));
    }
}