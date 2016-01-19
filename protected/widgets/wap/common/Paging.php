<?php
/**
 * class Paging
 *
 * @author : tanpv
 */
class Paging extends CLinkPager
{
    public $pages;
    public $current_paging = null;
    public function run()
    {
       $this->render('PagingWidget', array('pages' => $this->pages, 'current_paging' => $this->current_paging));
	}
}
?>
