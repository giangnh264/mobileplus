<?php
class jwPlayerAlbumWidget extends CWidget
{
    public $id='myalbum-player';
    public $assetsPath;
    public $data;
    public $primary='html5';//html5, flash, primaryCookie
    public $autostart='false';
    public $albumId;
    public $offset=0;//0: xuat hien ngay; n: xuat hien sau n(s)
    public $albumObject;
    public $songs;
    public $cached=true;
    public function init()
    {

        $assets = dirname(__FILE__) . '/assets';
        $this->assetsPath  = Yii::app()->assetManager->publish($assets,false,1,YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->assetsPath . '/css/stylejwp.css');
        $cs->registerScriptFile($this->assetsPath . '/jwplayer.js');
        $album = AlbumModel::model()->findByPk($this->albumId);
        $this->albumObject = $album;
        $this->data = AlbumModel::model()->builDataPlayerAlbum($this->albumId,$this->cached);
        if(!empty($this->data)){
            $playlistIndex = AlbumModel::model()->getDataIndexAlbum();
            $indexPl = json_decode($this->data);
            $cs->registerScript('play_album_touch' . $this->id, "
            jwplayer('" . $this->id . "').setup({
                width: '100%',
                height: 35,
                playlist: " . $this->data . ",
                skin: '" . $this->assetsPath . "/vega-skin-album-min-2.xml',
                autostart: '" . $this->autostart . "',
                primary: '" . $this->primary . "'
            });", CClientScript::POS_END);
            $cs->registerScript('play_album_touch_option' . $this->id, "
            jwplayer().onReady(function() {
                var state = jwplayer().getState();
                if(state=='IDLE'){
                    $('#play').show();
                    $('#pause').hide();
                }
                jwplayer().setVolume(100);
            });
            var isShuffle = false;
            var currentId = 0;
            jwplayer().onPlaylistItem(function() {
                //logSongFlag = true;
                var currentItem = jwplayer().getPlaylistItem();
                currentId = currentItem['mediaid'];
                //$('#vg-player li').removeClass('active');
                //$('#vg-player-item-'+currentItem['mediaid']).addClass('active');
                $('#item-title').html(currentItem['title']);
            });

            jwplayer().onPlay(function(){
                var state = jwplayer().getState();
                if(state=='PLAYING'){
                    $('#play').hide();
                    $('#pause').show();
                }else{
                    $('#play').show();
                    $('#pause').hide();

                }
            });

                $('#play').click(function(){
                    jwplayer().play();
                    $('#play').hide();
                    $('#pause').show();
                });

                $('#pause').click(function(){
                    jwplayer().pause();
                    $('#play').show();
                    $('#pause').hide();
                });

                $('#next').click(function(){
                    var state = jwplayer().getState();
                    var curentIndex = jwplayer().getPlaylistIndex();
                    var totalItem = jwplayer().getPlaylist().length;
                    if(curentIndex<totalItem){
                        nextItem = curentIndex+1;
                    }else{
                        nextItem = 0;
                    }
                    if(isShuffle){
                        nextItem = randomItem();
                    }
                    jwplayer().playlistItem(nextItem);

                    return false;
                })

                $('#prev').click(function(){
                    var state = jwplayer().getState();
                    var curentIndex = jwplayer().getPlaylistIndex();
                    var totalItem = jwplayer().getPlaylist().length;
                    if(curentIndex <= 0){
                        nextItem = totalItem-1;
                    }else{
                        nextItem = curentIndex-1;
                    }
                    jwplayer().playlistItem(nextItem);
                    return false;
                })

                $('#repeat').click(function(){
                    $('#repeat').hide();
                    $('#playone').show();
                    jwplayer().setRepeat();
                    return false;
                })
                $('#playone').click(function(){
                    $('#repeat').show();
                    $('#playone').hide();
                    jwplayer().setRepeat();
                    return false;
                })

                $('#sequence').click(function(){
                    isShuffle = true;
                    $('#sequence').hide();
                    $('#shuffle').show();
                    jwplayer().setShuffle();
                    return false;
                })
                $('#shuffle').click(function(){
                    isShuffle = false;
                    $('#sequence').show();
                    $('#shuffle').hide();
                    jwplayer().setShuffle();
                    return false;
                })
                function randomItem(){
                    var playlist = jwplayer().getPlaylist();
                    var playlistsize = playlist.length;
                    var randomnumber=Math.floor(Math.random()*playlistsize)
                    return randomnumber;
                };
                ", CClientScript::POS_END);

            $cs->registerScript('play_album_this' . $this->id, "
            function playThis(index) {
					jwplayer().playlistItem(index);
            };", CClientScript::POS_END);
            $cs->registerScript('play_album_getlyrics' . $this->id, "
            function getLyrics() {
					var currentItem = jwplayer().getPlaylistItem();
                    itemId = currentItem.mediaid;
                    Popup.title_popup='Lời bài hát';
                    var lyrics = $('#lyrics-'+itemId).html();
                    lyrics = (lyrics=='') ? 'Lời bài hát đang được cập nhật!' : lyrics;
                    Popup.alert(lyrics);
            };", CClientScript::POS_END);

            $deviceType = 'mobile';
            $cs->registerScript('play_album_current' . $this->id, "
                var device_type = '".$deviceType."';
                var listPlayed =Array();
                var logPlayAlbumFlag = true;
                var logSongFlag = true;
                    jwplayer().onBeforePlay(function() {
                        var currentItem = jwplayer().getPlaylistItem();
                        itemId = currentItem.mediaid;
                        $('.nhacvnplayer ul li.item').removeClass('onpause');
                        $('.nhacvnplayer ul li.item').removeClass('playing');
                        $('.nhacvnplayer #song_'+itemId).addClass('playing');
                    });
                    jwplayer().onPause(function(){
                        var currentItem = jwplayer().getPlaylistItem();
                        itemId = currentItem.mediaid;
                        $('.nhacvnplayer ul li.item').removeClass('playing');
                        $('.nhacvnplayer #song_'+itemId).addClass('onpause');
                    });
					jwplayer().onPlaylistItem(function() {
					    logSongFlag = true;
                        var currentItem = jwplayer().getPlaylistItem();
                        itemId = currentItem.mediaid;
                        //$('.nhacvnplayer ul li.item').removeClass('playing');
                        //$('.nhacvnplayer #song_'+itemId).addClass('playing');
                        hashdis = new Hashids(has_key);
                        id = hashdis.encode(parseInt(itemId));
                        songId = 'so'+id;
	                    history.replaceState({}, '', '?st='+songId);
                    })
                    //log and track
                    jwplayer().onTime(function(event) {
                    if(Math.round(event.position) >=5){
                        if(logPlayAlbumFlag) {
                            logPlayAlbumFlag = false;
                            var action = 'Play Album';
                            if(in_array_item(listPlayed,'album_'+".$album->id.")){
                                var action = 'Replay Album';
                            }
                            var item = 'album_".$album->id."';
                            if(!in_array_item(listPlayed,item)){
                                listPlayed.push(item);
                            }
                            //console.log(device_type+'-'+action);
                            ga('send', 'event', device_type, action,'".CHtml::encode($album->name."-".$album->artist_name."-".$album->id)."');
                            ajax_load('/player/logAlbum',{'id':".$album->id."});
                        }
                        if(logSongFlag){
                            logSongFlag = false;
                            var currentItem = jwplayer().getPlaylistItem();
                            itemId = currentItem.mediaid;
                            itemTitle = currentItem.media_title;
                            itemDesc = currentItem.media_desc;
                            var action = 'Play Song';
							if(in_array_item(listPlayed,'song_'+itemId)){
								var action = 'Replay Song';
							}
							var item = 'song_'+itemId;
                            if(!in_array_item(listPlayed,item)){
                                listPlayed.push(item);
                            }
                            //console.log(device_type+'-'+action+'|'+itemId+'|'+itemTitle+'|'+itemDesc);
							ga('send', 'event', device_type, action, itemTitle+'-'+itemDesc+'-'+itemId);
							ajax_load('/player/logSong',{'id':itemId});
                        }
                    }

			    })", CClientScript::POS_END);


            if (isset($_GET['st']) && !empty($_GET['st'])) {
                $st = $_GET['st'];
                if(!is_numeric($st)) {
                    $hashStrId = substr($st, 2);
                    $hashids = new Hashids(Yii::app()->params["hash_url"]);
                    $parse = $hashids->decode($hashStrId);
                    $songId = $parse[0];
                    $index = isset($playlistIndex[$songId])?$playlistIndex[$songId]:0;
                }else{
                    $index = (int)($st-1);
                }
                if ($index >= 0) {
                    $cs->registerScript('play_album_st' . $this->id, "
                        var isFirst = true;
                        jwplayer().playlistItem(" . $index . ");
                        jwplayer().onQualityLevels(function(event){
                            if(isFirst){
                                isFirst=false;
                                $('.nhacvnplayer ul li.item').removeClass('playing');
                                $('.nhacvnplayer #playlist li.song-item-".$index."').addClass('onpause');
                            }
                        });
                        ", CClientScript::POS_END);
                }
            }
        }
        parent::init();
    }
    public function run()
    {
        $this->render('play_album');
    }
}