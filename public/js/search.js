var SEARCH = (function() {
    return function() {
        var avatar, picturesTrigger, closeTrigger, o_extras, resultContainer, searches;
        var properties_loaded = [];
        this.init = function() {
            searches = [];
            positionFilters();
            $(window).on('changed.zf.mediaquery', mediaQueryChanged);
            avatar = $('.picture img');
            picturesTrigger = $('.pictures-trigger');
            closeTrigger = $('.close-details');
            o_extras = $('.o-extra');
            o_extras.parent('li').find('span').click(function(e) {
                $(this).parent('li').find('i').click();
                $(this).parent('li').find('input').css('display', 'block');
            });
            $('.extras').hide();
            resultContainer = $('#resultsList');
            resultContainer.on('mouseenter', '.pictures-trigger', function(e) {
                $(this).css('opacity', 1)
            });
            resultContainer.on('mouseleave', '.pictures-trigger', function(e) {
                $(this).css('opacity', 0)
            });
            resultContainer.on('mouseenter', '.picture img', function(e) {
                if (e.target.src === "/images/icons/picture-trigger.png")
                    return;
                $(e.target).parent().find('.pictures-trigger').css('opacity', 1)
            });
            resultContainer.on('mouseleave', '.picture img', function(e) {
                if (e.target.src === "/images/icons/picture-trigger.png")
                    return;
                $(e.target).parent().find('.pictures-trigger').css('opacity', 0)
            });
            resultContainer.on('click', '.pictures-trigger', open_gallery);
            resultContainer.on('click', '.close-details', close_gallery);
            resultContainer.on('pictures-loaded', '.gallery-container', function(e) {
                $(e.target).find('div').unitegallery();
            });
            o_extras.click(check_extra);
        };
        var mediaQueryChanged = function(event, newSize, oldSize) {
            positionFilters()
        };
        var positionFilters = function() {
            var side = $('#side-filters');
            var offgrid = $('#side-filters-off');
            if (!Foundation.MediaQuery.atLeast('large')) {
                if (!offgrid.find('.filters').length) {
                    var f = side.find('.filters').detach();
                    offgrid.append(f);
                }
            } else {
                if (!side.find('.filters').length) {
                    f = offgrid.find('.filters');
                    side.append(f);
                }
            }
        };
        var check_extra = function(e, idselected) {
            if (idselected) {
                var id = idselected;
                var element = $('#e-' + id).siblings('i');
            } else {
                element = $(this);
                id = $(this).data('id');
            }
            if (element.hasClass('fa-square-o')) {
                element.removeClass('fa-square-o');
                $('#e-' + id).attr('checked', 'checked');
                element.addClass('fa-check-square');
                element.parent('li').find('span').toggleClass('selected');
            } else {
                element.removeClass('fa-check-square');
                $('#e-' + id).removeAttr('checked');
                element.addClass('fa-square-o');
                element.parent('li').find('span').toggleClass('selected');
            }
        };
        var open_gallery = function(e) {
            e.preventDefault();
            var element = $(e.target).parents('.property-long');
            var canvas = element.find('.more-details');
            var property = element.data('property');
            if ($.inArray(property, properties_loaded) != -1) {
                canvas.toggle();
            } else {
                load_images(canvas, property);
                properties_loaded.push(property);
            }
        };
        var close_gallery = function(e) {
            e.preventDefault();
            var element = $(e.target).parents('.property-long');
            var canvas = element.find('.more-details');
            canvas.hide()
        };
        var present_images = function(container, property, images) {
            function as_orbit() {
                var html = '<div><ul class="orbit-container property-images">' +
                    '<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>' +
                    '<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>';
                $.each(images, function(idx, element) {
                    html += '<li class="orbit-slide"><img src="/images/properties/' + property + '/' + element.localization + '" alt="' + element.description + '"></li>'
                });
                html += '</ul></div>';
                return html;
            }

            function as_unitegallery() {
                var html = '<div id="gallery' + property + '" style="display:none;">';
                var index = 0;
                $.each(images, function(idx, element) {
                    if (index < 5) {
                        html += '<a><img alt="' + (element.description ? element.description : '') + '" ' + //href missing to avoid default event
                            'src="/images/properties/' + property + '/30/' + element.localization + '" ' +
                            'data-image="/images/properties/' + property + '/' + element.localization + '" ' +
                            'data-description="' + (element.description ? element.description : '') + '"></a>';
                        index++;
                    }
                });
                html += '</div>';
                return html;
            }
            if (Foundation.MediaQuery.atLeast('large')) {
                container.html(as_unitegallery());
                container.find('#gallery' + property).unitegallery({ tiles_type: "nested" });
                container.trigger('pictures-loaded');
            } else {
                container.html(as_orbit());
                var elem = new Foundation.Orbit(container.find('.property-images'), {});
            }
        };
        var load_images = function(c, property) {
            var gallery = c.find('.gallery-container');
            gallery.html('<img class="loader" src="/images/watermark.png">');
            c.show();
            $.get('/property/' + property + '/images', {}, function(data) {
                present_images(gallery, property, data);
            })
        };
        // functions to search
        var gestor, action, price_min, price_max, currency, province, municipio, locality, rooms, baths, type, typechanged, state, cleaner,
            type_construction, surface_max, surface_min, extras, order, page, optionals, condition, give, want;

        var restartPagination = true;
        this.startSearchForm = function() {
            gestor = $('#gestor');
            action = $('#action');
            price_min = $('#price-min');
            price_max = $('#price-max');
            currency = $('#currency');
            condition = $('#condition');
            give = $('#give');
            want = $('#want');
            province = $('#province');
            municipio = $('#municipio');
            locality = $('#locality');
            rooms = $('#rooms');
            baths = $('#baths');
            type = $('#type');
            typechanged = false;
            state = $('#state');
            type_construction = $('#type_construction');
            surface_min = $('#surface-min');
            surface_max = $('#surface-max');
            order = $('#order');
            optionals = $('.hidden');
            cleaner = $('#cleaner');
            conditionOrPrice();
            o_extras.click(startAction);
            action.change(function(e) {
                conditionOrPrice();
                startAction(e);
            });
            price_max.change(startAction);
            price_min.change(startAction);
            currency.change(startAction);
            condition.change(changeCondition);
            if (condition.val() === 'user') {
                give.parent('div').show();
                want.parent('div').show();
            } else {
                give.parent('div').hide();
                want.parent('div').hide();
            }
            give.change(startAction);
            want.change(startAction);
            province.change(load_municipios);
            province.change(function(e) {
                locality.find('option').each(function(i, o) {
                    if (o.value != 0)
                        o.remove();
                });
                municipio.val(0);
                startAction(e)
            });
            municipio.change(load_localities);
            municipio.change(function(e) {
                locality.val('0');
                startAction(e)
            });
            gestor.change(startAction);
            locality.change(startAction);
            rooms.change(startAction);
            baths.change(startAction);
            type.change(startAction);
            state.change(startAction);
            type_construction.change(startAction);
            surface_max.change(startAction);
            surface_min.change(startAction);
            resultContainer.on('change', '#order', startAction);
            $('#resultsList').on('click', '#pagination a', function(e) {
                //e.preventDefault(); this works by adding the current search as get parameters to this href, default
                //behaviour for links is expected, should work after added url
                startAction(e);
            });
            cleaner.click(cleanSearch);
            updateOrders();
        };

        var startChangeType = function(e, exec_oncomplete) {
            typechanged = true;
            startAction
        }

        this.loadSearch = function(data) {
            if (data.gestor)
                gestor.attr('checked', 'checked');
            action.val(data.action);
            price_min.val(data.price_min);
            price_max.val(data.price_max);
            condition.val(data.condition);
            rooms.val(data.rooms);
            baths.val(data.baths);
            type.val(data.type);
            state.val(data.state);
            type_construction.val(data.type_construction);
            surface_max.val(data.surface_max);
            surface_min.val(data.surface_min);
            order.val(data.order);
            province.val(data.province);
            page = data.page;
            restartPagination = false;
            if (data.extras) {
                if (typeof(data.extras) == 'object') {
                    $.each(data.extras, function(index, value) {
                        check_extra(true, value);
                    });
                } else {
                    check_extra(true, data.extras);
                }
            }
            if (data.province != 0) {
                load_municipios(true, function() {
                    if (data.municipio) {
                        municipio.val(data.municipio);
                        load_localities(true, function() {
                            if (data.locality) {
                                locality.val(data.locality);
                            }
                            startAction(true);
                        })
                    } else {
                        startAction(true);
                    }
                });
            } else {
                startAction(true);
            }
        };
        var conditionOrPrice = function() {
            optionals.hide();
            if (action.val() == '1') {
                $('.show-for-comprar').show();
            } else if (action.val() == '2') {
                $('.show-for-permutar').show();
            } else {
                $('.show-for-rentar').show();
            }
        };
        var changeCondition = function(e) {
            if (condition.val() != 'user') {
                give.parent('div').hide();
                want.parent('div').hide();
                startAction(e)
            } else {
                give.parent('div').show();
                want.parent('div').show();
            }
        };
        var updateOrders = function() {
            if (action.val() == 2) {
                $('#order').find('option.ventas').hide();
            } else {
                $('#order').find('option.ventas').show();
            }
        };
        var startAction = function(e, exec_oncomplete) {
            if (validateSearchForm()) {
                $('#loader').show();
                extras = [];
                $('#extras').find('input[checked]').each(function(index, elem) { //can't use input:checked
                    extras.push(elem.value);
                });
                var data = {
                    action: action.val(),
                    price_min: price_min.val(),
                    price_max: price_max.val(),
                    condition: condition.val(),
                    currency: currency.val(),
                    province: province.val(),
                    municipio: municipio.val(),
                    locality: locality.val(),
                    rooms: rooms.val(),
                    baths: baths.val(),
                    type: type.val(),
                    state: state.val(),
                    type_construction: type_construction.val(),
                    surface_min: surface_min.val(),
                    surface_max: surface_max.val(),
                    extras: extras,
                    order: $('#order').val(),
                    path: window.location.pathname
                };
                if (gestor.is(':checked'))
                    data['gestor'] = gestor.val();
                if (restartPagination) { //on every search restart pagination unless page change was the reason to search
                    data['page'] = 1;
                } else {
                    data['page'] = page;
                }
                if (condition.val() === 'user' && !isNaN(give.val()) && !isNaN(want.val())) {
                    data['condition'] = give.val() + 'x' + want.val();
                }
                var list = $('#resultsList');
                $('.ajax-error').remove();
                $.each(searches, function(i, xhr) {
                    xhr.abort();
                });
                searches = [];
                if (e && $(e.target).parents('#pagination').length > 0) {
                    //e.preventDefault();
                    var link = $(e.target);
                    delete data['page'];
                    link.attr('href', link.attr('href') + '&' + $.param(data));
                    $('#loader').hide();
                    return;
                }

                var jqXhr = $.get(HELPERS.getLocalizedURL('/search'), data, function(data) {
                    list.empty().append(data);
                    updateOrders();
                    $('#loader').hide();
                }).fail(function(response) {
                    if (response.status != 0)
                        $('#progress').append('<span class="ajax-error">' + response.statusText + '</span>')
                });
                restartPagination = true;
                searches.push(jqXhr);
            }
        };
        var validateSearchForm = function() {
            var price_validation = (parseInt(price_min.val()) <= parseInt(price_max.val())) || price_max.val() === 'infinito';
            var surface_validation = parseInt(surface_min.val()) <= parseInt(surface_max.val());
            if (action.val() === '1') {
                return price_validation && surface_validation;
            } else {
                if (condition === 'user') {
                    return surface_validation && !isNaN(give.val()) && !isNaN(want.val())
                }
                return surface_validation;
            }
        };
        var load_municipios = function(e, after) {
            var p = province.val();
            $.get('/municipios/' + p, {}, function(data) {
                municipio.find('option').each(function(i, o) {
                    if (o.value != 0)
                        o.remove();
                });
                var m = data['municipios'];
                cache_localities = data['localities'];
                $.each(m, function(index, obj) {
                    municipio.append('<option value=' + obj.id + '>' + obj.name + '</option>');
                });
                if (after)
                    after();
            });
        };
        var load_localities = function(e, after) {
            var m = municipio.val();
            locality.find('option').each(function(i, o) {
                if (o.value != 0)
                    o.remove();
            });
            $.get('/localities/' + m, {}, function(data) {
                $.each(data, function(index, obj) {
                    locality.append('<option value=' + obj.id + '>' + obj.name + '</option>');
                });
            });
            if (after)
                after();
        };
        var cleanSearch = function(e) {
            gestor.attr('checked', 'checked');
            action.val(1);
            price_min.val(0);
            price_max.val(999999999);
            province.val(0);
            municipio.val(0);
            locality.val(0);
            rooms.val(1);
            baths.val(1);
            type.val(0);
            state.val(0);
            condition.val(0);
            give.val('');
            want.val('');
            type_construction.val(0);
            surface_min.val(0);
            surface_max.val(999999999);
            var parent_extras = $('#extras');
            parent_extras.find('input').removeAttr('checked');
            parent_extras.find('i').removeClass('fa-check-square').addClass('fa-square-o');
            parent_extras.find('span').removeClass('selected');
            startAction(e);
        };
    }
})();
$(document).ready(function() {
    var search = new SEARCH();
    search.init();
    search.startSearchForm();
});
