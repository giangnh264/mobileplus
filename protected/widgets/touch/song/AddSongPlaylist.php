<?php
class AddSongPlaylist extends CWidget
{
	public $phone='';
	public $popupId='';
	public function run()
	{
		if(!empty($this->phone))
			$playlist = WapPlaylistModel::model()->getPlaylistByPhone($this->phone);
		else 
			$playlist = array();
		$this->render('addSongPlaylist', array(
			'phone'=>$this->phone,	
			'popupId'=>$this->popupId,
			'playlist'=>$playlist
		));
	}
}