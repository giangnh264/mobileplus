$(document).ready(function () {
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