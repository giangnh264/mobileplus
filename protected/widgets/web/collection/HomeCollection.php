<?php
class HomeCollection extends CWidget {
	public function run() {
		$collection = WebCollectionModel::model()->getListHome(8);
		$this->render("home",compact("collection"));
	}
}