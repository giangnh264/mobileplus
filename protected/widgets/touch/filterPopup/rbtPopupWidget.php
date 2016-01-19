<?php
class rbtPopupWidget extends CWidget
{
	public $rbt_id='';
	public function run()
	{
		$params = array();
		$this->render('rbtPopup', 
				CMap::mergeArray(array(
					'rbt_id'=>$this->rbt_id,
				),
				$params
			)
		);
	}
}