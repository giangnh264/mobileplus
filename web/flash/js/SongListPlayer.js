var player = null;
var currentState = 'NONE';
var currentItem = -1;
var activity_logged = false;

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
    $("#playlist li").removeClass("active");
    $("#playlist li#song_" + obj.index).addClass("active");
    $("#active_song_id").val(2);
    /*$(".playlist li:eq(" + obj.index + ")").addClass("active");*/

    /*GET song lyric*/
    var song_id =  $("#playlist li#song_" + obj.index).val();
    var before_song_lyric = false;
    var success_song_lyric = function(html){
        if(html!=""){
            $(".box_lyric").html(html);
            if($("#lyric_box").height() > 198){
                $("#lyric_box").height("198px");
                $("#lyric_more").show();
            }else{
                $("#lyric_more").hide();
            }
        }
    }
    ajax_load(ajax_url,{'action':'songLyric','song_id':song_id}, before_song_lyric,success_song_lyric);
}
