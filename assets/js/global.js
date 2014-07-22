$(document).ready(function(){
    /*******************
     *  NAVBAR OFFSET  *
     *******************/
     $('.navbar-lower').affix({
        offset: {top: 30}
    });

    /***************************************
     *  BG IMG & COLOR VIA DATA ATTRIBUTE  *
     ***************************************/
    $('.row').each(function(){
        var img = $(this).data('img');
        var color = $(this).data('color');
        if(img){
            $(this).css('background-image','url(' + img + ')');
            $(this).addClass('bgimg');
            
        }
        if(color){
            var o = color.split(",")[1] || "90";
            o = "0." + o;
            var c = hexToRgb(color.split(",")[0]);
            if(img){
                $(this).css('box-shadow', 'inset 0 0 0 1000px rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + o + ')');
            }else{
                $(this).css('background-color',color.split(",")[0]);
            }
        }
    });

    /**************
     *  PARALLAX  *
     **************/
    $('.row[data-img]').each(function(){
        var $bgobj = $(this); // assigning the object
        var $window = $(window);

        $window.scroll(function() {
            var yPos = -($window.scrollTop() / ($bgobj.data('speed') || 30));
            $bgobj.css('backgroundPosition', '50% '+ yPos + 'px');
        }); 
    });

    $(".date").timeago(); 

    //header slider
    var slider = new BadassSlider($('#twitter'), 'ul>li', 10000);

});