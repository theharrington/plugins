(function($) {
    $('.wpfp-link').live('click', function() {
        dhis = $(this);

        wpfp_do_js( dhis, 1 );
        $tick = 1;
        // for favorite post listing page
        if (dhis.hasClass('remove-parent')) {
            dhis.parent("li").fadeOut();
        }
        if (dhis.html() === '<div class="icons favs add"></div>') {
                $fave = $("#favCount").html();
        $tick = 1;
        //console.log(Number($("#favCount").html()));
        //console.log(dhis.html());
        $("#favCount").html(Number(Number($tick) + Number($fave)));
        // for favorite post listing page
        } else {
        $("#favCount").html(Number($fave));                        
        $fave = $fave -1;
        }
        return false;
    });

function wpfp_do_js( dhis, doAjax ) {
    // loadingImg = dhis.prev();
    // loadingImg.show();
    beforeImg = dhis.prev().prev();
    beforeImg.hide();
    url = document.location.href.split('#')[0];
    params = dhis.attr('href').replace('?', '') + '&ajax=1';
    if ( doAjax ) {
        $.get(url, params, function(data) {
                dhis.parent().html(data);
                //console.log(dhis.parent().html(data))
                //console.log(dhis)
                if(typeof wpfp_after_ajax == 'function') {
                    wpfp_after_ajax( dhis ); // use this like a wp action.
                }
             // loadingImg.hide();
            }
        );
    } else {

}

}

})(jQuery);
