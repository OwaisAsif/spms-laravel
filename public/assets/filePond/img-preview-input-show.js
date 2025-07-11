/*!
 * FilePondPluginImagePreview 4.6.11
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit https://pqina.nl/filepond/ for details.
 */

/* eslint-disable */

(function(global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined'
        ? (module.exports = factory())
        : typeof define === 'function' && define.amd
            ? define(factory)
            : ((global = global || self),
                (global.FilePondNotePlugin = factory()));
})(this, function() {
    'use strict';

    var plugin = function plugin(fpAPI) {
        var addFilter = fpAPI.addFilter,
            utils = fpAPI.utils;
        var Type = utils.Type,
            createRoute = utils.createRoute,
            isFile = utils.isFile;
        console.log('Note', fpAPI);
        // called for each view that is created right after the 'create' method
        addFilter('CREATE_VIEW', function(viewAPI) {
            // get referennce to created view
            var is = viewAPI.is,
                view = viewAPI.view,
                query = viewAPI.query;

            var didLoadItem = function didLoadItem(_ref) {
                var root = _ref.root,
                    props = _ref.props;
                var id = props.id;
                var item = query('GET_ITEM', id);
                if ($(root.element).hasClass('filepond--file')){
                    console.log(item, item.filename, root, $(root.element).attr('class'));
                    let pencil = $('<div class="pencil-wrapper"><img src="' + pencilImgUrl + '" }}"></div>');
                    let controls = $(
                        '<div class="file-border-wrapper" style="display: none"> ' +
                        '<div style="" class="photo-label-controls"> ' +
                            'C: A <input type="checkbox" value="1" name="" class="file-border check-all"/> ' +
                            '單位 <input type="checkbox" value="1" name="room_'+item.filename+'" class="file-border"/> ' +
                            '呎吋 <input type="checkbox" value="1" name="size_'+item.filename+'" class="file-border"/>' +
                            '價錢 <input type="checkbox" value="1" name="price_'+item.filename+'" class="file-border"/>' +
                        '</div>' +
                        '<div style="" class="photo-label-controls"> ' +
                            'L: A <input type="checkbox" value="1" name="" class="file-border check-all"/> ' +
                            '單位 <input type="checkbox" value="1" name="label_room_'+item.filename+'" class="file-border"/> ' +
                            '呎吋 <input type="checkbox" value="1" name="label_size_'+item.filename+'" class="file-border"/>' +
                            '價錢 <input type="checkbox" value="1" name="label_price_'+item.filename+'" class="file-border"/>' +
                        '</div>' +
                        '<input type="text" name="label_'+item.filename+'" placeholder="label" class="file-label"/>' +
                        '<input type="checkbox" value="1" name="border_'+item.filename+'" class="file-border"/>' +
                        '<input type="text" placeholder="comment" name="note_'+item.filename+'" class="file-note"/>' +
                        '</div>');
                    $(root.element).append(pencil);
                    $(root.element).append(controls);
                    controls.find('.check-all').click(function (){
                        console.log('Check all', $(this), $(this).parent().find('checkbox'));
                        $(this).parent().find('input').prop('checked', $(this).prop('checked'));
                    });
                    pencil.click(function (){
                        controls.toggle();
                    });
                }
            }

            // start writing
            view.registerWriter(
                createRoute(
                    {
                        DID_LOAD_ITEM: didLoadItem,
                    }
                )
            );
        });

        // expose plugin
        return {
            options: {

            }
        };
    };

    // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
    var isBrowser =
        typeof window !== 'undefined' && typeof window.document !== 'undefined';
    if (isBrowser) {
        document.dispatchEvent(
            new CustomEvent('FilePond:pluginloaded', { detail: plugin })
        );
    }

    return plugin;
});