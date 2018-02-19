( function($) {
    "use strict";

    var api = wp.customize;

    window.jnews.output = window.jnews.output || {};

    jnews.output =
    {
        generate_style : function(value, option)
        {
            if(undefined === option.property)
            {
                option.property = '';
            }

            if(undefined === option.prefix)
            {
                option.prefix = '';
            }

            if(undefined === option.units)
            {
                option.units = '';
            }

            if(undefined === option.suffix)
            {
                option.suffix = '';
            }

            return option.property + ' : ' +  option.prefix + value + option.units + option.suffix + ';';
        },

        get_font_variant : function($variant)
        {
            if($variant === '100')          { return { 'weight' : '100', 'style' : 'normal'  };  }
            if($variant === '100reguler')   { return { 'weight' : '100', 'style' : 'reguler' };  }
            if($variant === '100italic')    { return { 'weight' : '100', 'style' : 'italic'  };  }
            if($variant === '200')          { return { 'weight' : '200', 'style' : 'normal'  };  }
            if($variant === '200reguler')   { return { 'weight' : '200', 'style' : 'reguler' };  }
            if($variant === '200italic')    { return { 'weight' : '200', 'style' : 'italic'  };  }
            if($variant === '300')          { return { 'weight' : '300', 'style' : 'normal'  };  }
            if($variant === '300reguler')   { return { 'weight' : '300', 'style' : 'reguler' };  }
            if($variant === '300italic')    { return { 'weight' : '300', 'style' : 'italic'  };  }
            if($variant === 'regular')      { return { 'weight' : '400', 'style' : 'normal'  };  }
            if($variant === 'italic')       { return { 'weight' : '400', 'style' : 'italic'  };  }
            if($variant === '400reguler')   { return { 'weight' : '400', 'style' : 'reguler' };  }
            if($variant === '400italic')    { return { 'weight' : '400', 'style' : 'italic'  };  }
            if($variant === '500')          { return { 'weight' : '500', 'style' : 'normal'  };  }
            if($variant === '500reguler')   { return { 'weight' : '500', 'style' : 'reguler' };  }
            if($variant === '500italic')    { return { 'weight' : '500', 'style' : 'italic'  };  }
            if($variant === '600')          { return { 'weight' : '600', 'style' : 'normal'  };  }
            if($variant === '600reguler')   { return { 'weight' : '600', 'style' : 'reguler' };  }
            if($variant === '600italic')    { return { 'weight' : '600', 'style' : 'italic'  };  }
            if($variant === '700')          { return { 'weight' : '700', 'style' : 'normal'  };  }
            if($variant === '700reguler')   { return { 'weight' : '700', 'style' : 'reguler' };  }
            if($variant === '700italic')    { return { 'weight' : '700', 'style' : 'italic'  };  }
            if($variant === '800')          { return { 'weight' : '800', 'style' : 'normal'  };  }
            if($variant === '800reguler')   { return { 'weight' : '800', 'style' : 'reguler' };  }
            if($variant === '800italic')    { return { 'weight' : '800', 'style' : 'italic'  };  }
            if($variant === '900')          { return { 'weight' : '900', 'style' : 'normal'  };  }
            if($variant === '900reguler')   { return { 'weight' : '900', 'style' : 'reguler' };  }
            if($variant === '900italic')    { return { 'weight' : '900', 'style' : 'italic'  };  }
        },

        generate_font_style : function(value)
        {
            var style = '';

            if(value['font-family'] !== '')
            {
                style += 'font-family: ' + value['font-family'] + '; ';

                if( value['variant'] && value['variant'].constructor === Array && value['variant'].length === 1 )
                {
                    var variant = this.get_font_variant(value['variant'][0]);
                    style += 'font-weight : ' + variant['weight'] + '; ';
                    style += 'font-style : ' + variant['style'] + '; ';
                }


                if(value['font-size'] && value['font-size'] !== '')
                {
                    style += 'font-size: ' + value['font-size'] + '; ';
                }

                if(value['letter-spacing'] && value['letter-spacing'] !== '')
                {
                    style += 'letter-spacing: ' + value['letter-spacing'] + '; ';
                }

                if(value['color'] && value['color'] !== '')
                {
                    style += 'color : ' + value['color'] + '; ';
                }

                if(value['line-height'] && value['line-height'] !== '')
                {
                    style += 'line-height: ' + value['line-height'] + '; ';
                }

                if(value['text-transform'] && value['text-transform'] !== '')
                {
                    style += 'text-transform : ' + value['text-transform'] + '; ';
                }

            }

            return style;
        },

        attach_google_font_header : function( value, setting )
        {
            var font_id = setting + "-css";

            // need to remove the font first
            jQuery("#" + font_id).remove();

            var variant = [];
            var subset = [];

            if( value['variant'] && value['variant'].constructor === Array )
            {
                if( value['variant'].length === 1 )
                {
                    variant = ['reguler'];
                } else {
                    variant = value['variant'];
                }
            }

            if( value['subsets'] && value['subsets'].constructor === Array )
            {
                subset = value['subsets'];
            }

            var font_family = 'family=' + value['font-family'] + ":" + variant.join(',');
            var font_subset = 'subset=' + subset.join(',');

            var url = "//fonts.googleapis.com/css?" + encodeURI(font_family + '&' + font_subset);
            jQuery( 'head' ).append( '<link rel="stylesheet" id="' + font_id + '" href="' + url + '" type="text/css" media="all">' );
        },

        handle_inline_style : function(setting, value, option)
        {
            var obj = this;

            if(undefined !== option.element)
            {
                var css = obj.generate_style(value, option);
                var currentCss = $(option.element).attr('style');

                if(undefined === currentCss)
                {
                    currentCss = '';
                }

                $(option.element).attr('style', currentCss + css);
            }
        },

        handle_remove_class : function(value, option)
        {
            if ( 1 === value || '1' === value || true === value || 'true' === value || 'on' === value)
            {
                $(option.element).removeClass(option.property);
            }

            if(0 === value || '0' === value || false === value || 'false' === value || 'off' === value)
            {
                $(option.element).addClass(option.property);
            }
        },

        handle_inline_spacing : function(value, option)
        {
            value = JSON.parse(value);

            if(option.property === 'padding')
            {
                $(option.element).css({
                    'padding-top'       : value['top'],
                    'padding-left'      : value['left'],
                    'padding-bottom'    : value['bottom'],
                    'padding-right'     : value['right']
                });
            }

            if(option.property === 'margin')
            {
                $(option.element).css({
                    'margin-top'       : value['top'],
                    'margin-left'      : value['left'],
                    'margin-bottom'    : value['bottom'],
                    'margin-right'     : value['right']
                });
            }
        },

        handle_add_class : function(value, option)
        {
            if ( 1 === value || '1' === value || true === value || 'true' === value || 'on' === value)
            {
                $(option.element).addClass(option.property);
            }

            if(0 === value || '0' === value || false === value || 'false' === value || 'off' === value)
            {
                $(option.element).removeClass(option.property);
            }
        },

        handle_switch_class : function(value, option)
        {
            if ( 1 === value || '1' === value || true === value || 'true' === value || 'on' === value)
            {
                $(option.element).removeClass(option.property[0]).addClass(option.property[1]);
            }

            if(0 === value || '0' === value || false === value || 'false' === value || 'off' === value)
            {
                $(option.element).addClass(option.property[0]).removeClass(option.property[1]);
            }
        },

        handle_class_masking : function(value, option)
        {
            $.each(option.property, function(classkey, classname)
            {
                $(option.element).removeClass(classname);
            });

            $(option.element).addClass(option.property[value]);
        },

        is_excluded_font : function(font)
        {
            if(font.indexOf(',') >= 0) {
                font = font.substring(font.indexOf(','), 0);
            }
            var inarray = $.inArray(font, outputs['excluded_font']);
            return ( inarray >= 0 );
        },

        handle_output : function(output, newval, setting, result)
        {
            var obj = this;

            if ( undefined !== output && 0 < output.length )
            {
                var injectCss = '';
                var css = '';

                _.each( output, function( option )
                {
                    if(option.method === 'typography')
                    {
                        if(undefined !== option.element && newval['font-family'] !== '')
                        {
                            // add google font into header
                            if( ! obj.is_excluded_font( newval['font-family'] ) )
                            {
                                obj.attach_google_font_header(newval, setting);
                            }

                            // css inject
                            css = obj.generate_font_style(newval);
                            css = option.element + ' { ' + css + ' } ';
                            injectCss += css;
                        }
                    }

                    if(option.method === 'inline-css')
                    {
                        if(result) {
                            obj.handle_inline_style(setting, newval, option);
                        } else {
                            obj.handle_inline_style(setting, option.default, option);
                        }
                    }

                    if(option.method === 'inject-style')
                    {
                        if(undefined !== option.element)
                        {
                            css = obj.generate_style(newval, option);
                            css = option.element + ' { ' + css + ' } ';

                            injectCss += css;
                        }
                    }

                    if(option.method === 'remove-class')
                    {
                        if(result) {
                            obj.handle_remove_class(newval, option);
                        } else {
                            obj.handle_add_class(newval, option);
                        }
                    }

                    if(option.method === 'add-class')
                    {
                        if(result) {
                            obj.handle_add_class(newval, option);
                        } else {
                            obj.handle_remove_class(newval, option);
                        }
                    }

                    if(option.method === 'switch-class')
                    {
                        if(result) {
                            obj.handle_switch_class(newval, option);
                        } else {
                            obj.handle_switch_class(option.default, option);
                        }
                    }

                    if(option.method === 'class-masking')
                    {
                        if(result) {
                            obj.handle_class_masking(newval, option);
                        } else {
                            obj.handle_class_masking(option.default, option);
                        }
                    }

                    if(option.method === 'inline-spacing')
                    {
                        if(result) {
                            obj.handle_inline_spacing(newval, option);
                        } else {
                            obj.handle_inline_spacing(option.default, option);
                        }
                    }

                });

                var $selector = jQuery( '#jnews-customizer-postmessage_' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) );

                if(injectCss !== '' && result)
                {
                    if ( ! $selector.length )
                    {
                        jQuery( 'head' ).append( '<style id="jnews-customizer-postmessage_' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) + '"> ' + injectCss + ' </style>' );
                    } else
                    {
                        $selector.text( injectCss );
                    }
                } else {
                    $selector.remove();
                }

                if(!result && $selector.length)
                {
                    $selector.remove();
                }

            }
        }
    };

    _.each( outputs['control'], function( output, setting )
    {
        api( setting, function( value )
        {
            value.bind( function( newval )
            {
                jnews.output.handle_output(output, newval, setting, true);
            });
        });
    });


    api.bind( 'preview-ready', function()
    {
        api.preview.bind( 'active-callback-control-output', function( callback )
        {
            callback = JSON.parse(callback);

            var options = outputs['control'][callback.setting];
            var control_setting = api( callback.setting );

            jnews.output.handle_output(options, control_setting.get(), callback.setting, callback.result);
        } );
    } );


})( jQuery );
