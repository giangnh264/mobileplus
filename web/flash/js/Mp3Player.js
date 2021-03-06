var player = null;
var currentPosition = 0;
var currentState = 'NONE';
var activity_logged = false;

function playerReady(thePlayer) {
  player = document.getElementById(thePlayer.id);
  addListeners();
};

function addListeners() {
  //console.log("addListeners::", player);
  if (player) {
    player.addControllerListener("ITEM", "itemListener");
    player.addModelListener("STATE", "stateListener");
    player.addModelListener("TIME", "positionListener");
  } else {
    setTimeout("addListeners()",100);
  }
}

function itemListener(obj) { 
  var tmp = document.getElementById("stat");
  if (tmp) {
    tmp.innerHTML = "current state: PLAYING";
  }
}

function stateListener(obj) { //IDLE, BUFFERING, PLAYING, PAUSED, COMPLETED
  //console.log("stateListener::", obj.newstate);
  currentState = obj.newstate;
  var tmp = document.getElementById("stat");
  if (tmp) {
    tmp.innerHTML = "current state: " + currentState;
  }
  if(currentState == 'COMPLETED') {
    //alert('mp3 is COMPLETED');
  }
}

function positionListener(obj) {
  //console.log("positionListener::", obj.position);
  currentPosition = obj.position;
  var tmp = document.getElementById("tim");
  if (tmp) { tmp.innerHTML = "position: " + currentPosition; }
  if(!activity_logged && currentPosition > 20) {
    player.removeModelListener("TIME", "positionListener");
    //alert('position > 20');
    if (tmp) { tmp.innerHTML = "position > 20"; }
    /*log song*/
    var song_id = $("#song_id").val();
    var before_log_song = false;
    var success_log_song = function(html){
        if(html!="true"){
            activity_logged = true;
        }
    }
    var log_song_url = base_url+'player/logSong/'+song_id;
    ajax_load(log_song_url,{}, before_log_song,success_log_song);
  }
}