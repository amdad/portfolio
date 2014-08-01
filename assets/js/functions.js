function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

/**
        * @desc a slider that slides slides in the slider
        * @requires jQuery
        * @param slider - container of the slider
        * @param selector - selector of a single slide
        * @param time - how long one slide should be visible
        */
        function BadassSlider(slider, selector, time) {
            var timer, fadeTime = Math.round(time / 6);

            function showFirstSlide() {
                console.log("ok");
                slider.find(selector).first().fadeIn(fadeTime, function () {$(this).addClass('show'); });
            }


            function slide(direction){
                var current = slider.find('.show');

                current.fadeOut(fadeTime, function () {
                    $(this).removeClass('show');
                    
                    var next = current.next();
                    if(direction === "prev"){
                        next = current.prev();
                    }

                    console.log(next);

                    if (next.html()) {
                        next.fadeIn(fadeTime, function () {$(this).addClass('show'); });
                    } else {
                        showFirstSlide();
                    }
                });
            }

            showFirstSlide();

            if(time){
                timer = setInterval(function () {
                    slide("next");
                }, time);
            }
        }