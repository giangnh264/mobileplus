/*
 * Playlist Object for the jPlayer Plugin
 * http://www.jplayer.org
 *
 * Copyright (c) 2009 - 2011 Happyworm Ltd
 * Dual licensed under the MIT and GPL licenses.
 *  - http://www.opensource.org/licenses/mit-license.php
 *  - http://www.gnu.org/copyleft/gpl.html
 *
 * Author: Mark J Panaghiston
 * Version: 2.1.0 (jPlayer 2.1.0)
 * Date: 1st September 2011
 */

/* Code verified using http://www.jshint.com/ */
/*jshint asi:false, bitwise:false, boss:false, browser:true, curly:true, debug:false, eqeqeq:true, eqnull:false, evil:false, forin:false, immed:false, jquery:true, laxbreak:false, newcap:true, noarg:true, noempty:true, nonew:true, nomem:false, onevar:false, passfail:false, plusplus:false, regexp:false, undef:true, sub:false, strict:false, white:false */
/*global  jPlayerPlaylist: true, jQuery:false, alert:false */

(function($, undefined) {

	vplayer = function(cssSelector, playlist, options) {
		var self = this;

		this.playFix = false; // add fix android
		this.current = 0;
		this.loop = false; // Flag used with the jPlayer repeat event
		this.shuffled = false;
		this.removing = false; // Flag is true during remove animation, disabling the remove() method until complete.

		this.cssSelector = $.extend({}, this._cssSelector, cssSelector); // Object: Containing the css selectors for jPlayer and its cssSelectorAncestor
		this.options = $.extend(true, {}, this._options, options); // Object: The jPlayer constructor options for this playlist and the playlist options

		this.playlist = []; // Array of Objects: The current playlist displayed (Un-shuffled or Shuffled)
		this.original = []; // Array of Objects: The original playlist

		this._initPlaylist(playlist); // Copies playlist to this.original. Then mirrors this.original to this.playlist. Creating two arrays, where the element pointers match. (Enables pointer comparison.)

		// Setup the css selectors for the extra interface items used by the playlist.
		this.cssSelector.title = this.cssSelector.cssSelectorAncestor + " .jp-title"; // Note that the text is written to the decendant li node.
		this.cssSelector.playlist = this.cssSelector.cssSelectorAncestor + " .jp-playlist";
		this.cssSelector.next = this.cssSelector.cssSelectorAncestor + " .jp-next";
		this.cssSelector.previous = this.cssSelector.cssSelectorAncestor + " .jp-previous";
		this.cssSelector.shuffle = this.cssSelector.cssSelectorAncestor + " .jp-shuffle";
		this.cssSelector.shuffleOff = this.cssSelector.cssSelectorAncestor + " .jp-shuffle-off";

		// Override the cssSelectorAncestor given in options
		this.options.cssSelectorAncestor = this.cssSelector.cssSelectorAncestor;

		// Override the default repeat event handler
		this.options.repeat = function(event) {
			self.loop = event.jPlayer.options.loop;
		};

		// Create a ready event handler to initialize the playlist
		$(this.cssSelector.jPlayer).bind($.jPlayer.event.ready, function(event) {
			self._init();
		});

		// Create an ended event handler to move to the next item
		$(this.cssSelector.jPlayer).bind($.jPlayer.event.ended, function(event) {
			self.next();
		});

		// Create a play event handler to pause other instances
		$(this.cssSelector.jPlayer).bind($.jPlayer.event.play, function(event) {
			self._customPlay();
		});

		// Create a resize event handler to show the title in full screen mode.
		$(this.cssSelector.jPlayer).bind($.jPlayer.event.resize, function(event) {
			if(event.jPlayer.options.fullScreen) {
				$(self.cssSelector.title).show();
			} else {
				$(self.cssSelector.title).hide();
			}
		});

		// Apply Android fixes
		if(this.options['deviceOs']=='ANDROID'){
			// Fix playing new media immediately after setMedia.
			$(this.cssSelector.jPlayer).bind($.jPlayer.event.progress, function(event) {

				if(self.playFixRequired) {
					self.playFixRequired = false;

					// Enable the contols again
					// self.player.jPlayer('option', 'cssSelectorAncestor', self.cssSelectorAncestor);

					// Play if required, otherwise it will wait for the normal GUI input.
					if(self.playFix) {
						self.playFix = false;
						$(self.cssSelector.jPlayer).jPlayer("play");
					}
				}
			});
			$(this.cssSelector.jPlayer).bind($.jPlayer.event.pause, function(event) {
				if(self.endedFix) {
					var remaining = event.jPlayer.status.duration - event.jPlayer.status.currentTime;
					if(event.jPlayer.status.currentTime === 0 || remaining < 1) {
						// Trigger the ended event from inside jplayer instance.
						setTimeout(function() {
							self.jPlayer._trigger($.jPlayer.event.ended);
						},0);
					}
				}
			});

			// Apply Android fixes
			this.resetAndroid();
		}
		// End fix android
		if(this.options['debug_mode']){
			$(this.cssSelector.jPlayer).bind($.jPlayer.event.error, function(event) {
				 alert("Error Event: type = " + event.jPlayer.error.type); // The actual error code string. Eg., "e_url" for $.jPlayer.error.URL error.
				 switch(event.jPlayer.error.type) {
				 	case $.jPlayer.error.URL:
				 		reportBrokenMedia(event.jPlayer.error); // A function you might create to report the broken link to a server log.
				 		getNextMedia(); // A function you might create to move on to the next media item when an error occurs.
				 		break;
				 	case $.jPlayer.error.NO_SOLUTION:
				 		break;
				 }
			});
		}

		// Create click handlers for the extra buttons that do playlist functions.
		$(this.cssSelector.previous).click(function() {
			self.previous();
			$(this).blur();
			return false;
		});

		$(this.cssSelector.next).click(function() {
			self.next();
			$(this).blur();
			return false;
		});

		$(this.cssSelector.shuffle).click(function() {
			self.shuffle(true);
			return false;
		});
		$(this.cssSelector.shuffleOff).click(function() {
			self.shuffle(false);
			return false;
		}).hide();

		// Put the title in its initial display state
		if(!this.options.fullScreen) {
			$(this.cssSelector.title).hide();
		}

		// Remove the empty <li> from the page HTML. Allows page to be valid HTML, while not interfereing with display animations
		$(this.cssSelector.playlist + " ul").empty();

		// Create .live() handlers for the playlist items along with the free media and remove controls.
		this._createItemHandlers();

		// Instance jPlayer
		$(this.cssSelector.jPlayer).jPlayer(this.options);
	};

	vplayer.prototype = $.extend(true, jPlayerPlaylist.prototype,{
        _init: function() {
            self = this;
            this._refresh(function() {
                if(self.options.playlistOptions.autoPlay) {
                    self.play(self.current);
                } else {
                    self.select(self.current);
                }
            });
            self._customInit(self);
        },
        _customInit: function(self){
            /* Khi click vao bai hat thi HIGHLIGHT */
            $('#listSongPlaylist li').each(function(i){
                $(this).bind('click',function(){
                    $('#listSongPlaylist li').removeClass('sing_play');
                    setTimeout(function(){
                        $('#listSongPlaylist li:nth-child('+(i+1)+')').addClass('sing_play');
                        self.select(i);
                        self.play(i);
                    },100);

                });
            });
            /* Button Ko hoi lai nua */
            $("#dontask_btn").click(function(){
                self.options['is_confirm'] = 0;
                $('#confirm_play').dialog('close');
                self._callCharging();
            });

             /* Button Tiep tuc */
            $("#continue_btn").click(function(){
                $('#confirm_play').dialog('close');
                self._callCharging();
            });

            $("#playingtext marquee").html("<span class='playingsong'>"+this.playlist[0].title+"</span>");
            $('.jp-controls').show();
        },
        _highlight: function(index) {
			if(this.playlist.length && index !== undefined) {
				$('#listSongPlaylist li').removeClass("sing_play");
				$("#listSongPlaylist li:nth-child(" + (index + 1) + ")").addClass("sing_play");

                /* request downloadPrice, sendPrice cho bai hat dc chon */
                var baseid = (this.playlist[index].base_id != null)? this.playlist[index].base_id :0 ;
                getDownloadPrice(this.playlist[index].song_id,baseid);
			}
		},
		play: function(index) {
            /* hien thi ten bai hat dang play */
            $("#playingtext marquee").html("<span class='playingsong'>"+this.playlist[index].title+"</span>");
            /* request downloadPrice, sendPrice cho bai hat dc chon */
            var baseid = (this.playlist[index].base_id != null)? this.playlist[index].base_id :0 ;


			/* neu ko la Album (la Playlist), thi voi moi Bai Hat se set option "pause" = 1 (Ko tu dong play) Truoc khi Charging */
			if(!$("#albumId").length){
				this.options['pause'] = 1;
                /* voi moi lan charge 1 bai hat/ album thi set trang thai CHUA CHARGE */
                this.options['charged'] = 0;
			}

			index = (index < 0) ? this.original.length + index : index; // Negative index relates to end of array.
			if(0 <= index && index < this.playlist.length) {
				if(this.playlist.length) {
					this.select(index);
					if(this.options['deviceOs']=='ANDROID'){
						this.playFix = true;
						this.playFixRequired = true;
						this.endedFix = true;
					}else{
						$(this.cssSelector.jPlayer).jPlayer("play");
					}
				}
			} else if(index === undefined) {
				if(this.options['deviceOs']=='ANDROID'){
					this.playFix = true;
					this.playFixRequired = true;
					this.endedFix = true;
				}else{
					$(this.cssSelector.jPlayer).jPlayer("play");
				}
			}

            if(this.options['error_'] == 1)
                return false;
            return true;
		},
		resetoption: function(option, value) { // For changing playlist options only
			if(value === undefined) {
				return this.options[option];
			}
			this.options[option] = value;
			return this;
		},

		logcharging:function(index, isAlbum){
            song_id = this.playlist[index].song_id;
            base_id = this.playlist[index].base_id;
            var link = "";
            if(!isAlbum)
                link = this.options['chargingPlay']+"?id="+song_id+"&base_id="+base_id;
            else
                link = this.options['chargingAlbum']+"?id="+$("#albumId").val();
            var self = this;

            /* key cua mang charging: luu songId Or  albumId */
            arr_key = (isAlbum)? $("#albumId").val(): song_id;
            /* Da charge roi */
            if(arr_charging[arr_key] != null)
                return true;

            $.ajax({
                type: "GET",
                url: link,
                context: document.body,
                success: function(data){
                    arr_charging[arr_key] = 1;
                    /* error */
                    if(data != 'success' && data != ""){
                        self.options['error_msg'] = ''+data+'';
                        $("#error_msg").html(''+data+'');
                        _dialog("error_play","");

                        self.options['error_'] = 1;
                        self.pause();
                        return false;
                    }
                    /* charging success */
                    /* Huy bo trang thai pause cua bai hat */
					self.options['pause'] = 0;
                    $(self.cssSelector.jPlayer).jPlayer("play");
                    /* CHARGE thanh cong */
                    self.options['charged'] = 1;
                    var today = new Date();
                    if(!isAlbum)
                        localStorage.setItem('song_'+song_id, today.getTime());
                    else
                        localStorage.setItem('album_'+$("#albumId").val(), today.getTime());
                    return true;
                },
                complete:function(){
                },
                statusCode: {
                    404: function() {
                        alert('page not found');
                    }
                }
            });

        },

        _customPlay: function()
        {
            var self = this;
            var index = self.current;
            var itemId = -1;
            var itemKey = '';
            /* mac dinh showPopup = 1, voi nhung bai hat/ album nguoi dung da nghe trong vong 24h thi showPopup = 0 */
            var showPopup = 1;

            var isAlbum = ($("#albumId").length)? 1 : 0;
            if(!isAlbum){
                itemId = self.playlist[index].song_id;
                itemKey = 'song_'+itemId;
            }
            else{
                itemId = $("#albumId").val();
                itemKey = 'album_'+itemId;
            }

            if(localStorage.getItem(itemKey) != null){
                var today = new Date();
                var now = today.getTime();
                var duration = Math.abs((now - localStorage.getItem(itemKey))/1000);/* seconds */
                if (duration < 24*60*60) {
                    showPopup = 0;
                }
            }



			/* Get trang thai Pause cua bai hat:
			Playlist: voi moi bai hat, neu chua Charging thi bi pause
			Album	: Chi bi pause bai dau tien choi
			*/
			if(self.options['pause'])
				$(this.cssSelector.jPlayer).jPlayer("pause");

			/* khi error thi ko play va thong bao loi */
            if(self.options['error_'] == 1){
                self.pause();
                $("#error_msg").html(''+self.options['error_msg']+'');
                _dialog("error_play","");
                return false;
            }
            /* chua DK */
            if(self.options['is_sub'] != 1 && self.options['is_confirm'] == 1 && self.options['charged'] == 0 && showPopup == 1){
                    _dialog("confirm_play","",200);
            }
            /* Da DK */
            else
                self._callCharging();
        },
        _callCharging: function(){
            var self = this;
            var index = self.current;
            var isAlbum = ($("#albumId").length)? 1 : 0;
            var ret = self.logcharging(index, isAlbum);
            if(!ret)
                return false;
            return true;
        },
		setMedia: function(media) {
			this.media = media;

			// Apply Android fixes
			this.resetAndroid();

			// Set the media
			$(this.cssSelector.jPlayer).jPlayer("setMedia", this.media);
			//$(this.cssSelector.jPlayer).jPlayer("play");
			return this;
		},

		resetAndroid: function() {
			// Apply Android fixes
			//if($.jPlayer.platform.android) {
			if(this.options['deviceOs']=='ANDROID'){
				this.playFix = false;
				this.playFixRequired = true;
				this.endedFix = true;
				// Disable the controls
				// this.player.jPlayer('option', 'cssSelectorAncestor', '#NeverFoundDisabled');
			}
		}


	});
})(jQuery);
