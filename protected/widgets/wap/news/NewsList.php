<?php
/**
 * class NewsList
 *
 * @author : longtv
 */
class NewsList extends CWidget
{
    public $newsList;
    public $newsPages;
    public $type;

    public function init()
    {
    }

    public function run()
    {
        $this->render('NewsListWidget', array('newsList' => $this->newsList, 'newsPages' => $this->newsPages, 'type'=>$this->type));
    }
}
?>
