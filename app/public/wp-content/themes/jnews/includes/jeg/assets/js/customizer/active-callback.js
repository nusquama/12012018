wp.customize.bind( 'ready', function () {
    
    var api = wp.customize;

    var callback_compare = function(value1, value2, compare)
    {
        if(compare === '===') {
            return value1 === value2;
        }

        if(compare === '=' || compare === '==' || compare === 'equals' || compare === 'equal') {
            return value1 == value2;
        }

        if(compare === '!=') {
            return value1 !== value2;
        }

        if(compare === '!=' || compare === 'not equal') {
            return value1 != value2;
        }

        if(compare === '>=' || compare === 'greater or equal' || compare === 'equal or greater') {
            return value1 >= value2;
        }

        if(compare === '<=' || compare === 'smaller or equal' || compare === 'equal or smaller') {
            return value1 <= value2;
        }

        if(compare === '>' || compare === 'greater') {
            return value1 > value2;
        }

        if(compare === '<' || compare === 'smaller') {
            return value1 < value2;
        }

        if(compare === 'in' || compare === 'contains') {
            var result = value1.indexOf(value2);
            return result >= 0;
        }
    };

    var get_status_flag = function(activevar)
    {
        var flag = true;

        _.each( activevar, function( active )
        {
            var control_setting = api(active.setting);
            flag = flag && callback_compare(active.value, control_setting.get(), active.operator);
        });

        return flag;
    };

    _.each( activecallback, function( activevar, setting )
    {

        // control field
        api.control(setting, function(control)
        {
            var result = get_status_flag(activevar);
            control.active.set( result );

            _.each( activevar, function( active )
            {
                var control_setting = api(active.setting);
                control_setting.bind(function() {
                    var result = get_status_flag(activevar);
                    control.active.set( result );

                    var obj = { setting : setting, result : result };
                    api.previewer.send('active-callback-control-output', JSON.stringify(obj));
                });

            });
        });

        // section
        api.section(setting, function(section)
        {
            var result = get_status_flag(activevar);
            section.active.set( result );

            _.each( activevar, function( active )
            {
                var control_setting = api(active.setting);
                control_setting.bind(function() {
                    var result = get_status_flag(activevar);
                    section.active.set( result );
                });

            });
        });

        // panel
        api.panel(setting, function(panel)
        {
            var result = get_status_flag(activevar);
            panel.active.set( result );

            _.each( activevar, function( active )
            {
                var control_setting = api(active.setting);
                control_setting.bind(function() {
                    var result = get_status_flag(activevar);
                    panel.active.set( result );
                });

            });
        });

    });

});
