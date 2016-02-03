$(document).ready(function () {
        $('.icon_menu_phone').on('click', function(){
            //var heightSet = $( document ).height() >= $( window ).height() ? $( document ).height() : $( window ).height();
            //var heightSet = $( 'aside' ).height();
            var heightSet = $( window ).height();
            if ($('.menu-list').hasClass('hidden')) {
                // Show overlay background
                $('#overlay-bg').css({
                    height: heightSet + 'px',
                    width: '100%',
                    left: '275px',
                    display: 'block'
                });
                $('.menu-list').removeClass('hidden');
                $('.menu-list').css({
                    position: 'absolute',
                    top: '0px',
                    left: '0px'
                    /*height: heightSet + 'px'*/
                });
                /*$('section').css({
                 height: heightSet + 'px'
                 })*/
                $('#page').css({
                    height: heightSet + 'px',
                    overflow: 'hidden'
                })
                $('#header_phone').css({
                    position: 'absolute',
                    left: '275px',
                    opacity: '0.6',
                    top: '0px'
                });
                $('#header_phone').css({
                    position: 'static'
                });
                $('header').css({
                    left: '275px'
                });
            }
            else {
                $('#header_phone').css({
                    left: 0,
                    width: pw + 'px',
                    position: 'absolute',
                    opacity: '1',
                });
                $('#header_phone').css({
                    width: 'auto',
                    position: 'relative'
                });
                $('#page').css({
                    height: 'auto',
                    //overflow: 'hidden'
                })
                $('#overlay-bg').css({
                    height: '0',
                    width: '0',
                    display: 'none'
                });
                $('.menu-list').addClass('hidden');
                var pw = $(window).width();

                $('header').css({
                    left: 0
                });
            }
        });
        $('#overlay-bg').on('click', function(){
            if (!$('.icon_menu_phone').hasClass('hidden')) {
                $('#page').css({
                    height: 'auto',
                    //overflow: 'hidden'
                })
                $('#overlay-bg').css({
                    height: '0',
                    width: '0',
                    display: 'none'
                });
                $('.menu-list').addClass('hidden');
                var pw = $(window).width();
                $('#header_phone').css({
                    left: 0,
                    width: pw + 'px',
                    position: 'absolute',
                    opacity: '1'
                });
                $('#header_phone').css({
                    position: 'relative',
                    width: 'auto'
                });
                $('header').css({
                    left: 0
                });
                return false;
            }
        });
        /* AJAX LINK POPUP */
        $('a.has-ajax-pop').on('click', function () {
            var link = $(this).attr("rel");
            open_popup(link);
            return false;
        });

        $('.product_mobile').on('click', function () {
            var href = $('#link_channel_app').val();
            window.location.href = href;
        });

        $('.product_web').on('click', function () {
            var href = $('#link_channel_web').val();
            window.location.href = href;
        });
    }
);
var open_popup = function (url) {
    jQuery.ajax({
        'onclick': '$("#dialog").dialog("option", "position", "center").dialog("open"); return false;',
        'url': url,
        'type': 'GET',
        'cache': false,
        'beforeSend': function () {
            //overlay_show();
        },
        'success': function (html) {
            jQuery('#dialog').html(html);
            //overlay_hide();
        },
        'complete': function () {
            //overlay_hide();
        }
    });
}