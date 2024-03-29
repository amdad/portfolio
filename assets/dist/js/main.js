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

    $('.blog .post .content').responsiveEqualHeightGrid();

    $('.pagination .disabled').click(function(event){
        event.preventDefault();
    });

    //Tell me what you do with your big fat butt
    $('.button').click(function(){
      $(this).parent().parent().ClassyWiggle('start', {limit: 4});
    });
});

(function($) {

  /**
   * Set all elements within the collection to have the same height.
   */
  $.fn.equalHeight = function(){
    var heights = [];
    $.each(this, function(i, element){
      $element = $(element);
      var element_height;
      // Should we include the elements padding in it's height?
      var includePadding = ($element.css('box-sizing') == 'border-box') || ($element.css('-moz-box-sizing') == 'border-box');
      if (includePadding) {
        element_height = $element.innerHeight();
      } else {
        element_height = $element.height();
      }
      heights.push(element_height);
    });
    this.height(Math.max.apply(window, heights));
    return this;
  };

  /**
   * Create a grid of equal height elements.
   */
  $.fn.equalHeightGrid = function(columns){
    var $tiles = this;
    $tiles.css('height', 'auto');
    for (var i = 0; i < $tiles.length; i++) {
      if (i % columns === 0) {
        var row = $($tiles[i]);
        for(var n = 1;n < columns;n++){
          row = row.add($tiles[i + n]);
        }
        row.equalHeight();
      }
    }
    return this;
  };

  /**
   * Detect how many columns there are in a given layout.
   */
  $.fn.detectGridColumns = function() {
    var offset = 0, cols = 0;
    this.each(function(i, elem) {
      var elem_offset = $(elem).offset().top;
      if (offset === 0 || elem_offset == offset) {
        cols++;
        offset = elem_offset;
      } else {
        return false;
      }
    });
    return cols;
  };

  /**
   * Ensure equal heights now, on ready, load and resize.
   */
  $.fn.responsiveEqualHeightGrid = function() {
    var _this = this;
    function syncHeights() {
      var cols = _this.detectGridColumns();
      _this.equalHeightGrid(cols);  
    }
    $(window).bind('resize load', syncHeights);
    syncHeights();
    return this;
  };

})(jQuery);
/*!
 * jQuery ClassyWiggle
 * www.class.pm
 *
 * Written by Marius Stanciu - Sergiu <marius@class.pm>
 * Licensed under the MIT license www.class.pm/LICENSE-MIT
 * Version 1.2.0
 *
 */

(function($) {
    $.fn.ClassyWiggle = function(method, options) {
        options = $.extend({
            degrees: ['2', '4', '2', '0', '-2', '-4', '-2', '0'],
            delay: 35,
            limit: null,
            randomStart: true,
            onWiggle: function(o) {

            },
            onWiggleStart: function(o) {

            },
            onWiggleStop: function(o) {

            }
        }, options);
        var methods = {
            wiggle: function(o, step) {
                if (step === undefined) {
                    step = options.randomStart ? Math.floor(Math.random() * options.degrees.length) : 0;
                }
                if (!$(o).hasClass('wiggling')) {
                    $(o).addClass('wiggling');
                }
                var degree = options.degrees[step];
                $(o).css({
                    '-webkit-transform': 'rotate(' + degree + 'deg)',
                    '-moz-transform': 'rotate(' + degree + 'deg)',
                    '-ms-transform': 'rotate(' + degree + 'deg)',
                    '-o-transform': 'rotate(' + degree + 'deg)',
                    '-sand-transform': 'rotate(' + degree + 'deg)',
                    'transform': 'rotate(' + degree + 'deg)'
                });
                if (step === (options.degrees.length - 1)) {
                    step = 0;
                    if ($(o).data('wiggles') === undefined) {
                        $(o).data('wiggles', 1);
                    }
                    else {
                        $(o).data('wiggles', $(o).data('wiggles') + 1);
                    }
                    options.onWiggle(o);
                }
                if (options.limit && $(o).data('wiggles') == options.limit) {
                    return methods.stop(o);
                }
                o.timeout = setTimeout(function() {
                    methods.wiggle(o, step + 1);
                }, options.delay);
            },
            stop: function(o) {
                $(o).data('wiggles', 0);
                $(o).css({
                    '-webkit-transform': 'rotate(0deg)',
                    '-moz-transform': 'rotate(0deg)',
                    '-ms-transform': 'rotate(0deg)',
                    '-o-transform': 'rotate(0deg)',
                    '-sand-transform': 'rotate(0deg)',
                    'transform': 'rotate(0deg)'
                });
                if ($(o).hasClass('wiggling')) {
                    $(o).removeClass('wiggling');
                }
                clearTimeout(o.timeout);
                o.timeout = null;
                options.onWiggleStop(o);
            },
            isWiggling: function(o) {
                return !o.timeout ? false : true;
            }
        };
        if (method === 'isWiggling' && this.length === 1) {
            return methods.isWiggling(this[0]);
        }
        this.each(function() {
            if ((method === 'start' || method === undefined) && !this.timeout) {
                methods.wiggle(this);
                options.onWiggleStart(this);
            }
            else if (method === 'stop') {
                methods.stop(this);
            }
        });
        return this;
    };
})(jQuery);
/**
 * Timeago is a jQuery plugin that makes it easy to support automatically
 * updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * @name timeago
 * @version 1.4.1
 * @requires jQuery v1.2.3+
 * @author Ryan McGeary
 * @license MIT License - http://www.opensource.org/licenses/mit-license.php
 *
 * For usage and examples, visit:
 * http://timeago.yarp.com/
 *
 * Copyright (c) 2008-2013, Ryan McGeary (ryan -[at]- mcgeary [*dot*] org)
 */

(function (factory) {
  factory(jQuery);
}(function ($) {
  $.timeago = function(timestamp) {
    if (timestamp instanceof Date) {
      return inWords(timestamp);
    } else if (typeof timestamp === "string") {
      return inWords($.timeago.parse(timestamp));
    } else if (typeof timestamp === "number") {
      return inWords(new Date(timestamp));
    } else {
      return inWords($.timeago.datetime(timestamp));
    }
  };
  var $t = $.timeago;

  $.extend($.timeago, {
    settings: {
      refreshMillis: 60000,
      allowPast: true,
      allowFuture: false,
      localeTitle: false,
      cutoff: 0,
      strings: {
        prefixAgo: null,
        prefixFromNow: null,
        suffixAgo: "ago",
        suffixFromNow: "from now",
        inPast: 'any moment now',
        seconds: "less than a minute",
        minute: "about a minute",
        minutes: "%d minutes",
        hour: "about an hour",
        hours: "about %d hours",
        day: "a day",
        days: "%d days",
        month: "about a month",
        months: "%d months",
        year: "about a year",
        years: "%d years",
        wordSeparator: " ",
        numbers: []
      }
    },

    inWords: function(distanceMillis) {
      if(!this.settings.allowPast && ! this.settings.allowFuture) {
          throw 'timeago allowPast and allowFuture settings can not both be set to false.';
      }

      var $l = this.settings.strings;
      var prefix = $l.prefixAgo;
      var suffix = $l.suffixAgo;
      if (this.settings.allowFuture) {
        if (distanceMillis < 0) {
          prefix = $l.prefixFromNow;
          suffix = $l.suffixFromNow;
        }
      }

      if(!this.settings.allowPast && distanceMillis >= 0) {
        return this.settings.strings.inPast;
      }

      var seconds = Math.abs(distanceMillis) / 1000;
      var minutes = seconds / 60;
      var hours = minutes / 60;
      var days = hours / 24;
      var years = days / 365;

      function substitute(stringOrFunction, number) {
        var string = $.isFunction(stringOrFunction) ? stringOrFunction(number, distanceMillis) : stringOrFunction;
        var value = ($l.numbers && $l.numbers[number]) || number;
        return string.replace(/%d/i, value);
      }

      var words = seconds < 45 && substitute($l.seconds, Math.round(seconds)) ||
        seconds < 90 && substitute($l.minute, 1) ||
        minutes < 45 && substitute($l.minutes, Math.round(minutes)) ||
        minutes < 90 && substitute($l.hour, 1) ||
        hours < 24 && substitute($l.hours, Math.round(hours)) ||
        hours < 42 && substitute($l.day, 1) ||
        days < 30 && substitute($l.days, Math.round(days)) ||
        days < 45 && substitute($l.month, 1) ||
        days < 365 && substitute($l.months, Math.round(days / 30)) ||
        years < 1.5 && substitute($l.year, 1) ||
        substitute($l.years, Math.round(years));

      var separator = $l.wordSeparator || "";
      if ($l.wordSeparator === undefined) { separator = " "; }
      return $.trim([prefix, words, suffix].join(separator));
    },

    parse: function(iso8601) {
      var s = $.trim(iso8601);
      s = s.replace(/\.\d+/,""); // remove milliseconds
      s = s.replace(/-/,"/").replace(/-/,"/");
      s = s.replace(/T/," ").replace(/Z/," UTC");
      s = s.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); // -04:00 -> -0400
      s = s.replace(/([\+\-]\d\d)$/," $100"); // +09 -> +0900
      return new Date(s);
    },
    datetime: function(elem) {
      var iso8601 = $t.isTime(elem) ? $(elem).attr("datetime") : $(elem).attr("title");
      return $t.parse(iso8601);
    },
    isTime: function(elem) {
      // jQuery's `is()` doesn't play well with HTML5 in IE
      return $(elem).get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
    }
  });

  // functions that can be called via $(el).timeago('action')
  // init is default when no action is given
  // functions are called with context of a single element
  var functions = {
    init: function(){
      var refresh_el = $.proxy(refresh, this);
      refresh_el();
      var $s = $t.settings;
      if ($s.refreshMillis > 0) {
        this._timeagoInterval = setInterval(refresh_el, $s.refreshMillis);
      }
    },
    update: function(time){
      var parsedTime = $t.parse(time);
      $(this).data('timeago', { datetime: parsedTime });
      if($t.settings.localeTitle) {
        $(this).attr("title", parsedTime.toLocaleString());
      }
      refresh.apply(this);
    },
    updateFromDOM: function(){
      $(this).data('timeago', { datetime: $t.parse( $t.isTime(this) ? $(this).attr("datetime") : $(this).attr("title") ) });
      refresh.apply(this);
    },
    dispose: function () {
      if (this._timeagoInterval) {
        window.clearInterval(this._timeagoInterval);
        this._timeagoInterval = null;
      }
    }
  };

  $.fn.timeago = function(action, options) {
    var fn = action ? functions[action] : functions.init;
    if(!fn){
      throw new Error("Unknown function name '"+ action +"' for timeago");
    }
    // each over objects here and call the requested function
    this.each(function(){
      fn.call(this, options);
    });
    return this;
  };

  function refresh() {
    var data = prepareData(this);
    var $s = $t.settings;

    if (!isNaN(data.datetime)) {
      if ( $s.cutoff === 0 || Math.abs(distance(data.datetime)) < $s.cutoff) {
        $(this).text(inWords(data.datetime));
      }
    }
    return this;
  }

  function prepareData(element) {
    element = $(element);
    if (!element.data("timeago")) {
      element.data("timeago", { datetime: $t.datetime(element) });
      var text = $.trim(element.text());
      if ($t.settings.localeTitle) {
        element.attr("title", element.data('timeago').datetime.toLocaleString());
      } else if (text.length > 0 && !($t.isTime(element) && element.attr("title"))) {
        element.attr("title", text);
      }
    }
    return element.data("timeago");
  }

  function inWords(date) {
    return $t.inWords(distance(date));
  }

  function distance(date) {
    return (new Date().getTime() - date.getTime());
  }

  // fix for IE6 suckage
  document.createElement("abbr");
  document.createElement("time");
}));