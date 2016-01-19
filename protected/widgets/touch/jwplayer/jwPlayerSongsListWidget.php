<?php
class jwPlayerSongsListWidget extends CWidget
{
    public $id='song-list-player';
    public $assetsPath;
    public $imageAds = '';
    public $data;
    public $primary='html5';//html5, flash, primaryCookie
    public $autostart='false';
    public $offset=0;//0: xuat hien ngay; n: xuat hien sau n(s)

    public $songs;
    public $songsListObject;
    public $songListIndex;
    public $classScroll='';
    public function init()
    {
        $this->autostart = 'false';
        $assets = dirname(__FILE__) . '/assets';
        $this->assetsPath  = Yii::app()->assetManager->publish($assets,false,1,YII_DEBUG);

        if(empty($this->imageAds))
        {
            $this->imageAds = '/web/images/bg_default.png';
        }
        if(empty($this->data))
        {
            $data[] = array(
                'file'=>$this->assetsPath.'/default.mp3',
                'label'=>'128K'
            );
            $data[] = array(
                'file'=>$this->assetsPath.'/default.mp3',
                'label'=>'320K VIP'
            );
        }
        //echo json_encode($data);exit;
        $source = json_encode($data);
        $songsListObject = $this->songsListObject;
        $listIndex = $this->songListIndex;
        $indexPl = json_decode($songsListObject);
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->assetsPath . '/css/stylejwp.css');
        $cs->registerScriptFile($this->assetsPath . '/jwplayer.js', CClientScript::POS_END);
        $cs->registerScript('play_song_list'.$this->id,"
            jwplayer('".$this->id."').setup({
                width: '100%',
                height: 35,
                playlist: " . $songsListObject . ",
                skin: '" . $this->assetsPath . "/vega-skin-album-min-2.xml',
                autostart: '" . $this->autostart . "',
                primary: '" . $this->primary . "'
                /*plugins: {
                    '".$this->assetsPath."/vast.js': {
                      client:'vast',
                      schedule:{
                        overlay: { offset: ".$this->offset.", tag: '".Yii::app()->createUrl('/player/banner')."', type:'nonlinear' }
                      }
                    }
                }*/
            });
        ",CClientScript::POS_END);
        $cs->registerScript('play_song_list_this'.$this->id,"
            function playThis(index) {
					jwplayer().playlistItem(index);
            }

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
                    $('#sequence').hide();
                    $('#shuffle').show();
                    jwplayer().setShuffle();
                    return false;
                })
                $('#shuffle').click(function(){
                    $('#sequence').show();
                    $('#shuffle').hide();
                    jwplayer().setShuffle();
                    return false;
                })
            ;
        ",CClientScript::POS_END);
        $detect = new Mobile_Detect;
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
        $cs->registerScript('play_song_list_current'.$this->id,"
                var device_type = '".$deviceType."';
                var listPlayed =Array();
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
                jwplayer().onTime(function(event) {
                    if(Math.round(event.position) >=5){
                        if(logSongFlag){
                            logSongFlag = false;
                            var currentItem = jwplayer().getPlaylistItem();
                            itemId = currentItem.mediaid;
                            itemTitle = currentItem.media_title;
                            itemDesc = currentItem.media_desc;
                            var action = 'Play Song';
                            test = in_array(listPlayed,'song_'+itemId);
							if(in_array(listPlayed,'song_'+itemId)){
								var action = 'Replay Song';
							}
							var item = {id:'song_'+itemId};
                            if(!in_array(listPlayed,item.id)){
                                listPlayed.push(item);
                            }
                            //console.log(device_type+'-'+action+'|'+itemId+'|'+itemTitle+'|'+itemDesc);
							ga('send', 'event', device_type, action, itemTitle+'-'+itemDesc+'-'+itemId);
							ajax_load('/player/logSong',{'id':itemId});
                        }
                    }

			    })
        ",CClientScript::POS_END);

        if(isset($_GET['st']) && !empty($_GET['st'])){
            $st = $_GET['st'];
            if(!is_numeric($st)) {
                $hashStrId = substr($st, 2);
                $hashids = new Hashids(Yii::app()->params["hash_url"]);
                $parse = $hashids->decode($hashStrId);
                $songId = $parse[0];
                $index = isset($listIndex[$songId])?$listIndex[$songId]:0;
            }else{
                $index = (int)($st-1);
            }

            if($index>=0){
                $cs->registerScript('play_song_list_st'.$this->id,"
					jwplayer().playlistItem(".$index.");
					var isFirst = true;
					jwplayer().onQualityLevels(function(event){
                        if(isFirst){
                            isFirst=false;
                            $('.nhacvnplayer ul li.item').removeClass('playing');
                            $('.nhacvnplayer #playlist li.song-item-".$index."').addClass('onpause');
                        }
                    });
					",CClientScript::POS_END);
            }
        }
        if(count($this->songs)>8) {
            $this->classScroll = 'album_song_list';
        }
        parent::init();
    }
    public function run()
    {
        $this->render('play_song_list');
    }
}