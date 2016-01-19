<?php
/**
 * class Playlist
 *
 * @author : tanpv
 */
class Playlist extends CWidget
{
    public $playlists;
    public $playlistPages;
    public $type;
    public $defaultAvatar = false;
    public $link = null;
    
    public function init()
    {
    }

    public function run()
    {
        $this->render('PlayListWidget', array('playlists' => $this->playlists, 'link' => $this->link, 'playlistPages' => $this->playlistPages, 'type' => $this->type, 'defaultAvatar' => $this->defaultAvatar));
    }
}
?>
