$(document).ready(function(){
    $('.navbar-lower').affix({
        offset: {top: 30}
    });

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
});

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
/*
$(function(){

    var header = $('.header'),
        canvas = $('<canvas></canvas>').appendTo(header)[0],

        background = new Image(),

        ctx    = canvas.getContext('2d'),
        color  = 'white',
        idle   = null;

        canvas.width         = window.innerWidth;
        canvas.height        = header.outerHeight() * 1.3;
        canvas.style.display = 'block';
        background.src = "http://www.devface.be/img/park-place.jpg";

        ctx.fillStyle = color;
        ctx.lineWidth = .1;
        ctx.strokeStyle = color;

        

    var dots          = { count: (canvas.width < 640 ? 70 : 250), distance: 80, d_radius: 150, array: [] };

    function Dot(){
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;

        this.vx = -.5 + Math.random();
        this.vy = -.5 + Math.random();

        this.radius = Math.random();
    }

    Dot.prototype = {
        create: function(){
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
            ctx.fill();
        },

        animate: function(){

            for(var i = 0, dot=false; i < dots.count; i++){

                dot = dots.array[i];

                if(dot.y < 0 || dot.y > canvas.height){
                    dot.vx = dot.vx;
                    dot.vy = - dot.vy;
                }else if(dot.x < 0 || dot.x > canvas.width){
                    dot.vx = - dot.vx;
                    dot.vy = dot.vy;
                }
                dot.x += dot.vx;
                dot.y += dot.vy;
            }
        },

        line: function(){
            for(var i = 0; i < dots.count; i++){
                for(var j = 0; j < dots.count; j++){
                    i_dot = dots.array[i];
                    j_dot = dots.array[j];

                    if((i_dot.x - j_dot.x) < dots.distance && (i_dot.y - j_dot.y) < dots.distance && (i_dot.x - j_dot.x) > - dots.distance && (i_dot.y - j_dot.y) > - dots.distance){
                            ctx.beginPath();
                            ctx.moveTo(i_dot.x, i_dot.y);
                            ctx.lineTo(j_dot.x, j_dot.y);
                            ctx.stroke();
                            ctx.closePath();
                    }
                }
            }
        }
    };

    function createDots(){

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawImageProp(ctx, background, 0, 0, canvas.width, canvas.height, 0.5, 0.5);
        
        for(var i = 0; i < dots.count; i++){
            dots.array.push(new Dot());
            dot = dots.array[i];

            dot.create();
        }

        dot.line();
        dot.animate();
    }

        // Make sure the image is loaded first otherwise nothing will draw.
    background.onload = function(){
        idle = setInterval(createDots, 1000/30);
    }

    function drawImageProp(ctx, img, x, y, w, h, offsetX, offsetY) {

    if (arguments.length === 2) {
        x = y = 0;
        w = ctx.canvas.width;
        h = ctx.canvas.height;
    }

    /// default offset is center
    offsetX = offsetX ? offsetX : 0.5;
    offsetY = offsetY ? offsetY : 0.5;

    /// keep bounds [0.0, 1.0]
    if (offsetX < 0) offsetX = 0;
    if (offsetY < 0) offsetY = 0;
    if (offsetX > 1) offsetX = 1;
    if (offsetY > 1) offsetY = 1;

    var iw = img.width,
        ih = img.height,
        r = Math.min(w / iw, h / ih),
        nw = iw * r,   /// new prop. width
        nh = ih * r,   /// new prop. height
        cx, cy, cw, ch, ar = 1;

    /// decide which gap to fill    
    if (nw < w) ar = w / nw;
    if (nh < h) ar = h / nh;
    nw *= ar;
    nh *= ar;

    /// calc source rectangle
    cw = iw / (nw / w);
    ch = ih / (nh / h);

    cx = (iw - cw) * offsetX;
    cy = (ih - ch) * offsetY;

    /// make sure source rectangle is valid
    if (cx < 0) cx = 0;
    if (cy < 0) cy = 0;
    if (cw > iw) cw = iw;
    if (ch > ih) ch = ih;

    /// fill image in dest. rectangle
    ctx.drawImage(img, cx, cy, cw, ch,  x, y, w, h);
}
});
*/