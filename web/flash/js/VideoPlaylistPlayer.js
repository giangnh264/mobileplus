var player = null;
var currentState = 'NONE';
var currentItem = -1;
var activity_logged = false;

$(document).ready(function() {
})

function playerReady(thePlayer) {
  player = document.getElementById(thePlayer.id);
  printPlaylistData();
};

function PlayerplaySong(songindex) {
  player.sendEvent("ITEM", songindex);
}

function printPlaylistData() {
  var plst = player.getPlaylist();
  if (plst && plst.length > 0) {
    player.addControllerListener("ITEM", "nextTracker");
    player.addModelListener("STATE", "stateListener");
  }
};

function stateListener(obj) { //IDLE, BUFFERING, PLAYING, PAUSED, COMPLETED
  //console.log("stateListener::", obj.newstate);
  currentState = obj.newstate;
  if(currentState == 'COMPLETED') {
    //alert('mp3 is COMPLETED:: ' + currentItem);
  }
}

function nextTracker(obj) {
    $("#video-playlist-item li").removeClass("active");
    $("#video-playlist-item li#video-item-" + obj.index).addClass("active");
    var reg =$("#video-playlist-item li#video-item-" + obj.index).children().attr('rel');
    jQuery.ajax({
        'url':'/Videoplaylist/getInfo',
        'type':'POST',
        'data':{id:reg},
        'cache':false,
        'beforeSend':function(){
        },
        'complete':function(){
        },
        'success':function(html){
            $('.name_detail').html(html.name);
            $(".lyric_name").html(html.name);
            $(".vp_artist").html(html.artist_name);
            $(".v_viewcount").html(html.view_count + " lượt xem");
            if(html.lyric != ''){
                $("#lyric_box").html(html.lyric);
            }else{
                $("#lyric_box").html('Lời bài hát đang được cập nhật');
            }
        }
    });
    /*log video*/
    var video_id = reg;
    var before_log_video = false;
    var success_log_video = function(html){
        if(html!="true"){
            activity_logged = true;
        }
    }
    var log_video_url = base_url+'player/logVideo/'+video_id;
    ajax_load(log_video_url,{}, before_log_video,success_log_video);
}

$(function () {
    $('.scroll-pane').jScrollPane();
    
    $("#video-playlist-item li").live("click", function () {
    	var attrID = $(this).attr("id");
    	var objIndex = attrID.replace("video-item-","");
        var reg = $(this).children().attr('rel');
        jQuery.ajax({
            'url':'/Videoplaylist/getInfo',
            'type':'POST',
            'data':{id:reg},
            'cache':false,
            'beforeSend':function(){
            },
            'complete':function(){
            },
            'success':function(html){
                $('.name_detail').html(html.name);
                $(".lyric_name").html(html.name);
                $(".vp_artist").html(html.artist_name);
                $(".v_viewcount").html(html.view_count + " lượt xem");
                if(html.lyric != ''){
                    $("#lyric_box").html(html.lyric);
                }else{
                    $("#lyric_box").html('Lời bài hát đang được cập nhật');
                }
                }
        });
    	PlayerplaySong(objIndex);
    })
});