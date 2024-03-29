/**
 * Binds a UIkit htmleditor widget to <htmleditor> elements.
 */

(function($){


    var template = $.UIkit.Utils.template([
        '<div class="uk-overlay uk-display-block">',
            '{{{ img }}}',
            '<div class="uk-overlay-area">',
                '<div class="uk-overlay-area-content">',
                    '<div><span class="uk-badge">{{{ alt }}}</span></div>',
                    '<div class="uk-button-group uk-margin-top">',
                        '<button class="uk-button uk-button-primary js-editor-image js-config" type="button" title="Pick image"><i class="uk-icon-hand-o-up"></i></button>',
                        '<button class="uk-button uk-button-danger js-editor-image js-remove" type="button" title="Remove image"><i class="uk-icon-trash-o"></i></button>',
                    '</div>',
                '</div>',
            '</div>',
        '</div>'
    ].join(""));

    $.UIkit.plugin('htmleditor', 'image', {

        init: function(editor) {

            var images = [];

            editor.element.on('render', function() {

                    var regexp = editor.getMode() != 'gfm' ? /<img(.+?)>/gi : /(?:<img(.+?)>|!(?:\[([^\n\]]*)\])(?:\(([^\n\]]*)\))?)/gi, img;

                    images = editor.replaceInPreview(regexp, function(data) {

                    if (data.matches[0][0] == '<') {

                        if (data.matches[0].match(/js\-no\-parse/)) return false;

                        var matchesSrc = data.matches[0].match(/\ssrc="(.*?)"/),
                        matchesAlt = data.matches[0].match(/\salt="(.*?)"/);

                        data['src'] = matchesSrc ? matchesSrc[1] : '';
                        data['alt'] = matchesAlt ? matchesAlt[1] : '';
                        data['handler'] = function(src) {

                            var src = ' src="' + src +'"', alt = ' alt="'+data['alt']+'"', output = data.matches[0];

                            output = matchesSrc ? output.replace(matchesSrc[0], src) : [output.slice(0, 4), src, output.slice(4)].join('');
                            output = matchesAlt ? output.replace(matchesAlt[0], alt) : [output.slice(0, 4), alt, output.slice(4)].join('');

                            data.replace(output);
                        };

                    } else {

                        data['src'] = data.matches[3].trim();
                        data['alt'] = data.matches[2];
                        data['handler'] = function(src) {
                            data.replace('![' + data['alt'] + '](' + src + ')');
                        };
                    }

                    if (data['src'] && 'http://'!==data['src'].trim()) {
                        img = '<img src="'+data['src']+'" alt="'+data['alt']+'">';
                    } else {
                        img = [
                            '<div class="uk-placeholder uk-placeholder-large uk-text-center uk-vertical-align">',
                                '<div class="uk-vertical-align-middle"><i class="uk-icon-picture-o"></i></div>',
                            '</div>'
                            ].join("");
                    }

                    return template({ 'img': img, alt: data['alt'] || 'No alt text'  }).replace(/(\r\n|\n|\r)/gm, '');
                });

            });

            editor.preview.on('click', '.js-editor-image.js-config', function() {

                var data = images[editor.preview.find('.js-editor-image.js-config').index(this)];

                new PathPicker(function(path){
                    data.handler(path.replace('site:', COCKPIT_SITE_BASE_URL));
                }, "*.(jpg|png|gif)");
            });

            editor.preview.on('click', '.js-editor-image.js-remove', function() {
                images[editor.preview.find('.js-editor-image.js-remove').index(this)].replace('');
            });
        }
    });

    angular.module('cockpit.directives').directive("htmleditor", function($timeout){

        return {

            require: 'ngModel',
            restrict: 'E',

            link: function (scope, elm, attrs, ngModel) {

                var txt = $('<textarea class="js-htmleditor" style="display:none;"></textarea>'), htmleditor, options;

                options = $.extend({plugins:['base', 'markdown', 'image']}, scope.$eval(attrs.options));

                options.maxsplitsize = 300;

                elm.after(txt).hide();

                ngModel.$render = function() {

                    txt.val(ngModel.$viewValue || '');

                    if(!htmleditor) {

                        htmleditor = $.UIkit.htmleditor(txt, options);

                        setTimeout(function(){

                            htmleditor.editor.on("change", $.UIkit.Utils.debounce(function(){

                                ngModel.$setViewValue(htmleditor.editor.getValue());

                                if (!scope.$root.$$phase) {
                                    scope.$apply();
                                }
                            }, 100));

                            htmleditor.fit();

                        }, 50);

                    }
                };
            }
        };

    });

})(jQuery);