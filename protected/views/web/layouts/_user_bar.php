<!-- user board -->
<div class="content_bar hide">
    <div class="wrr-board-user">
        <div id="user_board">
        </div>
    </div>
</div>
<!-- end user board-->
<div class="ctr_bar">
    <ul class="user_nav">
        <li><a title="<?php echo Yii::t('web','Account information');?>" href="<?php echo Yii::app()->createUrl('/xhrUser/detail');?>"><i class="user-icon icon_user"></i></a></li>
        <li><a title="<?php echo Yii::t('web','My Playlist'); ?>" href="<?php echo Yii::app()->createUrl('/xhrUser/myplaylist');?>"><i class="user-icon icon_list"></i></a></li>
        <li><a title="<?php echo Yii::t('web','Recently Listen')?>" href="<?php echo Yii::app()->createUrl('/xhrUser/recent');?>"><i class="user-icon icon_his"></i></a></li>
        <li><a title="<?php echo Yii::t('web','Favourite')?>" href="<?php echo Yii::app()->createUrl('/xhrUser/favourite');?>"><i class="user-icon icon_ulike"></i></a></li>
        <li><a title="<?php echo Yii::t('web','Nghệ sỹ')?>" href="<?php echo Yii::app()->createUrl('/xhrUser/artist');?>"><i class="user-icon icon_artist"></i></a></li>

    </ul>
    <ul class="nav_bottom">
        <li><a id="scroller" class="uptop" href="#top"><span>&nbsp;</span></a></li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        //fade in/out based on scrollTop value
                $('#scroller').hide();
                $(window).scroll(function () {
                        if ($(this).scrollTop() > 0) {
                                $('#scroller').fadeIn();
                            } else {
                               $('#scroller').fadeOut();
                            }
                    });

                    // scroll body to 0px on click
                        $('#scroller').click(function () {
                                $('body,html').animate({
                                    scrollTop: 0
                                }, 400);
                    return false;
                });
        var toggleBarUser = {
            open: function(){
                $(".content_bar").removeClass("hide");
                $(".content_bar").addClass("show");
                //overlay_show();
                /*$("#overlay").css({
                    'background':'rgba(0, 0, 0, 0.5)',
                    'opacity':'1'
                })*/
                //$("#ovelay-loading").hide();
                //$('#box').css({"display":"none"});
                addScroll();
            },
            close: function(){
                $(".content_bar").removeClass("show");
                $(".content_bar").addClass("hide");
                overlay_hide();
                this.clearActive();
            },
            clearActive: function()
            {
                $(".user_nav li a").removeClass('active');
            }
        }
        $("#overlay").live("click", function(){
            toggleBarUser.close();
        })
        $(".user_nav li a").live("click",function(){
            var thisa = $(this);

            if(!thisa.hasClass("active")){
                var uhref = $(this).attr("href");
                $.ajax({
                    url: uhref,
                    type: 'post',
                    beforeSend: function(){
                        overlay_show();
                        //$("#overlay").html("<div id='ovelay-loading'>"+ajax_loading_content+"</div>");
                        //$('#user_board').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
                    },
                    //dataType: 'json',
                    success: function(data){
                        if(data==1){
                            //require user login
                            link = popup_login_url;
                            open_popup(link);
                        }else{
                            $(".user_nav li a").removeClass('active');
                            thisa.addClass("active");
                            $('#user_board').html(data);
                            toggleBarUser.open();
                            $('#box_load').hide();
                        }
                        //$('#user_board').remove('ovelay-loading-face');
                    }
                })

            }else{
                //thisa.removeClass("active");
                toggleBarUser.close();
            }
            return false;
        })

        $(".myplaylist li a.delete").live("click", function(){
            var id = $(this).attr("rel");
            $.ajax({
                url: '/xhrUser/deletePlaylist',
                data:{id:id},
                type: 'get',
                beforeSend: function(){
                    $("#box_load").show();
                },
                success: function(data){
                    $("#box_load").hide();
                    if(data==1){
                        $(".myplaylist li#myplaylist-"+id).remove();
                    }else{
                        alert(__t("Your request is invalid"));
                    }
                }
            })
        })
        $(".myplaylist li a.edit").live("click", function(){
            var xhr = $(this).attr("rel");
            open_popup_raw(xhr);
        })

        $('#xhrUser_load_ajax .ajax_load li a').live('click',function(){
            var rel = $(this).attr('rel');
            $.ajax({
                url: rel,
                type: 'GET',
                beforeSend: function(){
                    $('#user_board').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
                },
                success: function(data){
                    $('#user_board').html(data);
                    addScroll();
                },
                completed: function(){
                    //addScroll();
                }
            })
        })

        //resize window
        $( window ).resize(function() {
            addScroll();
        })

        //load scroll
    });
</script>