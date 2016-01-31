$(document).ready(function() {
    /* AJAX LINK POPUP */
    $('a.has-ajax-pop').on('click',function(){
        var link = $(this).attr("rel");
        open_popup(link);
        return false;
    });

     $('.product_mobile').on('click',function(){
         var url = '/product/loadmobile';
         jQuery.ajax({
             'url':url,
             'type':'GET',
             'cache':false,
             'beforeSend':function(){
                 //overlay_show();
             },
             'success':function(html){
                 //overlay_hide();
                 $('.wrr_items_list_resp').html(html);
                 $('.product_web').removeClass('selected ');
                 $('.product_mobile').addClass('selected ');
             },
             'complete':function(){
                 //overlay_hide();
             }
         });
     });

        $('.product_web').on('click',function(){
            var url = '/product/web';
            jQuery.ajax({
                'url':url,
                'type':'GET',
                'cache':false,
                'beforeSend':function(){
                    //overlay_show();
                },
                'success':function(html){
                    //overlay_hide();
                    $('.wrr_items_list_resp').html(html);
                    $('.product_mobile').removeClass('selected ');
                    $('.product_web').addClass('selected ');
                },
                'complete':function(){
                    //overlay_hide();
                }
            });
        });
        $('#btn-search-icon').on('click', function(){
            if($("#search-form").hasClass('hidden')){
                $("#search-form").removeClass('hidden');
            }else{
                $("#search-form").addClass('hidden');
            }

        })
    }

    );
var open_popup = function(url){
    jQuery.ajax({
        'onclick':'$("#dialog").dialog("option", "position", "center").dialog("open"); return false;',
        'url':url,
        'type':'GET',
        'cache':false,
        'beforeSend':function(){
            //overlay_show();
        },
        'success':function(html){
            jQuery('#dialog').html(html);
            //overlay_hide();
        },
        'complete':function(){
            //overlay_hide();
        }
    });
}