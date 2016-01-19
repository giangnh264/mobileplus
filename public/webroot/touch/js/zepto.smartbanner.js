/*!
 * jQuery Smart Banner
 * Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 */
!function ($) {
    var SmartBanner = function (options) {
        this.options = $.extend({}, $.smartbanner.defaults, options);

        var standalone = navigator.standalone; // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)

        // Detect banner type (iOS, Android, Windows Phone or Windows RT)
        if (this.options.force) {
            this.type = this.options.force
        } else if (navigator.userAgent.match(/iPad|iPhone|iPod/i) != null && navigator.userAgent.match(/Safari/i) != null) {
            if (
                (window.Number(navigator.userAgent.substr(navigator.userAgent.indexOf('OS ') + 3, 3).replace('_', '.')) < 6)
                || navigator.userAgent.match(/Version/i) == null
            )
                this.type = 'ios'; // Check webview and native smart banner support (iOS 6+)
        } else if (navigator.userAgent.match(/Android/i) != null) {
            this.type = 'android'
        }  else if (navigator.userAgent.match(/Windows Phone/i) != null) {
            this.type = 'windows-phone'
        }

        // Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner
        if (!this.type || standalone || this.getCookie('sb-closed') || this.getCookie('sb-installed')) {
            return
        }

        // Calculate scale
        this.scale = this.options.scale == 'auto' ? $(window).width() / window.screen.width : this.options.scale;
        if (this.scale < 1) this.scale = 1;

        // Get info from meta data
        var metaString, metaTrackingString, specificDeviceOption;
        switch(this.type) {
            case 'windows':
                metaString = 'meta[name="msApplication-WinPhonePackageUrl"]';
                metaTrackingString = 'meta[name="ms-store-phone-tracking"]';
                specificDeviceOption = this.options.windowsPhoneConfig || null;
                break;
            case 'windows-phone':
                metaString = 'meta[name="msApplication-WinPhonePackageUrl"]';
                metaTrackingString = 'meta[name="ms-store-phone-tracking"]';
                specificDeviceOption = this.options.windowsPhoneConfig || null;
                break;
            case 'android':
                metaString = 'meta[name="google-play-app"]';
                metaTrackingString = 'meta[name="google-play-app-tracking"]';
                specificDeviceOption = this.options.androidConfig || null;
                break;
            case 'ios':
                metaString = 'meta[name="apple-itunes-app"]';
                metaTrackingString = 'meta[name="apple-itunes-app-tracking"]';
                specificDeviceOption = this.options.iphoneConfig || null;
                break;
        }
        var meta = $(metaString);
        var metaTracking = $(metaTrackingString);

        if (meta.length == 0) return;
        if (metaTracking.length == 0) metaTracking = $('<meta name="" content="" />');

        // For Windows Store apps, get the PackageFamilyName for protocol launch
        if (this.type == 'windows-phone' || this.type == 'windows') {
            this.appId = meta.attr('content')
        } else {
            this.appId = /app-id=([^\s,]+)/.exec(meta.attr('content'))[1]
        }

        // Get Tracking URL :
        this.appTracking = metaTracking.attr('content');

        // Get Device Configuration Specific :
        if(specificDeviceOption)  $.extend(this.options, specificDeviceOption);

        // Get default Title and Author :
        this.title = this.options.title ? this.options.title : $('title').text().replace(/\s*[|\-·].*$/, '');
        this.author = this.options.author ? this.options.author : ($('meta[name="author"]').length ? $('meta[name="author"]').attr('content') : window.location.hostname);

        // Create banner
        this.create();
        this.show();
        this.listen();
    }
    SmartBanner.prototype = {

        constructor: SmartBanner

        , create: function() {
            var iconURL
                , link
                , inStore=this.options.price ? this.options.price + ' - ' + (this.type == 'android' ? this.options.inGooglePlay : this.type == 'ios' ? this.options.inAppStore : this.options.inWindowsStore) : ''
                , gloss=this.options.iconGloss === null ? (this.type=='ios') : this.options.iconGloss;
            switch(this.type){
                case('windows'):
                    link = 'http://windowsphone.com/s?appid=c4e37375-9c52-4778-9790-a6ff25efc57d';
                    break;
                case('windows-phone'):
                    link = 'http://windowsphone.com/s?appid='+this.appId;
                    break;
                case('android'):
                    link = 'market://details?id=' + this.appId;
                    break;
                case('ios'):
                    link = 'https://itunes.apple.com/' + this.options.appStoreLanguage + '/app/id' + this.appId;
                    break;
            }

            $('body').append('<div id="smartbanner" class="'+this.type+'"><div class="sb-container"><a href="#" class="sb-close">&times;</a><span class="sb-icon"></span><div class="sb-info"><strong>'+this.title+'</strong><span>'+this.author+'</span><span>'+inStore+'</span></div><a href="'+link+'" class="sb-button"><span>'+this.options.button+'</span></a></div></div>')

            if (this.options.icon) {
                iconURL = this.options.icon
            } else if ($('link[rel="apple-touch-icon-precomposed"]').length > 0) {
                iconURL = $('link[rel="apple-touch-icon-precomposed"]').attr('href')
                if (this.options.iconGloss === null) gloss = false
            } else if ($('link[rel="apple-touch-icon"]').length > 0) {
                iconURL = $('link[rel="apple-touch-icon"]').attr('href')
            } else if ($('meta[name="msApplication-TileImage"]').length > 0) {
                iconURL = $('meta[name="msApplication-TileImage"]').attr('content')
            } else if ($('meta[name="msapplication-TileImage"]').length > 0) { /* redundant because ms docs show two case usages */
                iconURL = $('meta[name="msapplication-TileImage"]').attr('content')
            }

            if (iconURL) {
                $('#smartbanner .sb-icon').css('background-image','url('+iconURL+')')
                if (gloss) $('#smartbanner .sb-icon').addClass('gloss')
            } else{
                $('#smartbanner').addClass('no-icon')
            }
            this.bannerHeight = $('#smartbanner').height() + 2

            if (this.scale > 1) {
                $('#smartbanner')
                    .css('height', parseFloat($('#smartbanner').css('height')) * this.scale)
                $('#smartbanner .sb-container')
                    .css('-webkit-transform', 'scale('+this.scale+')')
                    .css('-msie-transform', 'scale('+this.scale+')')
                    .css('-moz-transform', 'scale('+this.scale+')')
                    .css('width', $(window).width() / this.scale)
            }
        }

        , listen: function () {
            $('#smartbanner .sb-close').on('click',$.proxy(this.close, this))
            $('#smartbanner .sb-button').on('click',$.proxy(this.install, this))
        }

        , show: function(callback) {
            $('#smartbanner').animate({top:50},this.options.speedIn).addClass('shown')
            $('html').animate({marginTop:0},this.options.speedIn,'swing',callback)
        }

        , hide: function(callback) {
            $('#smartbanner').animate({display:'none'},this.options.speedOut).removeClass('shown')
            $('html').animate({marginTop:0},this.options.speedOut,'swing',callback)
        }

        , close: function(e) {
            e.preventDefault()
            this.hide()
            this.setCookie('sb-closed','true',this.options.daysHidden)
        }

        , install: function(e) {
            this.hide()
            this.setCookie('sb-installed','true',this.options.daysReminder)
        }

        , setCookie: function(name, value, exdays) {
            var exdate = new Date()
            exdate.setDate(exdate.getDate()+exdays)
            value=escape(value)+((exdays==null)?'':'; expires='+exdate.toUTCString())
            document.cookie=name+'='+value+'; path=/;'
        }

        , getCookie: function(name) {
            var i,x,y,ARRcookies = document.cookie.split(";")
            for(i=0;i<ARRcookies.length;i++) {
                x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="))
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1)
                x = x.replace(/^\s+|\s+$/g,"")
                if (x==name) {
                    return unescape(y)
                }
            }
            return null
        }

        // Demo only
        , switchType: function() {
            var that = this

            this.hide(function () {
                that.type = that.type == 'android' ? 'ios' : 'android'
                var meta = $(that.type == 'android' ? 'meta[name="google-play-app"]' : 'meta[name="apple-itunes-app"]').attr('content')
                that.appId = /app-id=([^\s,]+)/.exec(meta)[1]

                $('#smartbanner').detach()
                that.create()
                that.show()
            })
        }
    }

    $.smartbanner = function (option) {
        var $window = $(window)
            , data = $window.data('typeahead')
            , options = typeof option == 'object' && option
        if (!data) $window.data('typeahead', (data = new SmartBanner(options)))
        if (typeof option == 'string') data[option]()
    }

    // override these globally if you like (they are all optional)
    $.smartbanner.defaults = {
        title: null, // What the title of the app should be in the banner (defaults to <title>)
        author: null, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
        price: 'FREE', // Price of the app
        appStoreLanguage: 'us', // Language code for App Store
        inAppStore: 'On the App Store', // Text of price for iOS
        inGooglePlay: 'In Google Play', // Text of price for Android
        inWindowsStore: 'In the Windows Store', //Text of price for Windows
        icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
        iconGloss: null, // Force gloss effect for iOS even for precomposed
        button: 'VIEW', // Text for the install button
        url: null, // The URL for the button. Keep null if you want the button to link to the app store.
        scale: 'auto', // Scale based on viewport size (set to 1 to disable)
        speedIn: 300, // Show animation speed of the banner
        speedOut: 400, // Close animation speed of the banner
        daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
        daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
        force: null // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
    }

    $.smartbanner.Constructor = SmartBanner

}(window.Zepto);
