<?php

class ListContent extends CWidget
{
    public $title = 'Topic';
    public $curentId = 0;
    public $group = 'home';

    public function run()
    {
        $key_cache = $this->group . "_KEY";
        $topContent = Common::getCache($key_cache);
        if ($topContent === false) {
            $data = TopContentModel::model()->findAllByAttributes(array('group' => $this->group, 'status' => 1), array('order'=>'sorder ASC'));
            Common::setCache($key_cache, $data);
        }
        $title = $this->title;
        $curentId = $this->curentId;
        $this->render("list", compact("topContent", "title", "curentId"));
    }
}