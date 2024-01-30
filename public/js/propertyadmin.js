var PROPERTY_ADMIN = (function() {
    return function() {
        var table_properties;
        var modal, modalElement, tmplModalElement, loader, loaderElement, filters, filtersElement; //modals
        var searchButton, showOnly, orderBy, add_filter, filters_ok, filters_list_element, main_filters;
        var uploading = false;
        var selectedRow = false;
        var filters_list = [],
            filters_list_now = [];
        this.init = function() {
            table_properties = $('#admin_properties');
            table_properties.on('click', 'tr', function(e) {
                selectedRow = $(e.target).parents('tr');
            });
            searchButton = $('.search-button');
            searchButton.click(search);
            showOnly = $('#show');
            main_filters = $('#filters');
            add_filter = $('#add_filter');
            filters_list_element = $('#list_filters');
            filters_list_element.on('click', 'i', edit_filters);
            add_filter.click(edit_filters);
            filters_ok = $('#accept_filters');
            filters_ok.click(accept_filters);
            //showOnly.change(search);
            orderBy = $('#orderby');
            orderBy.change(search);
            $('.trigger_filters').click(load_filters);
            table_properties.on('click', '.trigger_images', load_images);
            table_properties.on('click', '.trigger_comments', load_comments);
            table_properties.on('click', '.trigger_contact', load_contacts);
            table_properties.on('click', '.trigger_action', load_actions);
            table_properties.on('click', '.trigger_days', load_days);
            table_properties.on('click', '.renovate', renovate_plan);
            table_properties.on('click', '.trigger_active', toggle_active);
            table_properties.on('click', '.trigger_concluded', toggle_concluded);
            table_properties.on('click', '.trigger_revo', load_revo);
            table_properties.on('click', '.trigger_delete', delete_prop);
            modalElement = $('#actions_container');
            tmplModalElement = modalElement.find('.container').html();
            modal = new Foundation.Reveal(modalElement, {
                closeOnClick: false,
                closeOnEsc: false,
                resetOnClose: true,
                vOffset: 0
            });
            modalElement.on('close.zf.trigger', function() {
                modalElement.off('open.zf.reveal');
                modalElement.off('click');
                modalElement.find('.container').html(tmplModalElement);
            });
            loaderElement = $('#loader_container');
            loader = new Foundation.Reveal(loaderElement, {
                closeOnClick: false,
                closeOnEsc: false
            });
            filtersElement = $('#filters_container');
            filters = new Foundation.Reveal(filtersElement, {
                closeOnClick: false,
                closeOnEsc: false
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        };
        var update_row = function() {
            var property_id = selectedRow.attr('id');
            $.get('/admin/properties/property-representation', { property_id: property_id }, function(data) {
                selectedRow.after(data);
                selectedRow.remove();
            });
        };
        //MODAL FILTERS FUNCTIONS
        var load_filters = function(e) {
            filters_list_now = [];
            for (var fi in filters_list) {
                if (filters_list[fi]) {
                    filters_list_now.push(filters_list[fi]);
                }
            }
            filters_list_element.html('');
            for (var f in filters_list_now) {
                filters_list_element.append('<span class="mini_badget">' + filters_list_now[f] + '<i class="fa fa-trash"></span>');
            }
            filters.open();
        };
        //END MODAL FILTERS FUNCTIONS
        //MODAL IMAGES FUNCTIONS
        var load_images = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/images', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_images_edition();
                    activate_dropzone(modalElement.find('#dropzone-area'), '#previews', id);
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_dropzone = function(element, previews_selector, property_id) {
            element.dropzone({
                autoDiscover: false,
                maxFilesize: 3,
                previewsContainer: previews_selector,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictRemoveFile: translate.dictRemoveFile,
                dictCancelUpload: translate.dictCancelUpload,
                dictCancelUploadConfirmation: translate.dictCancelUploadConfirmation,
                dictResponseError: translate.dictResponseError,
                dictFileTooBig: translate.dictFileTooBig,
                dictInvalidFileType: translate.dictInvalidFileType,
                dictFallbackMessage: translate.dictFallbackMessage,
                init: function() {
                    this.on("processing", function() {
                        uploading = true;
                    });
                    this.on("success", function(file, response) {
                        $(file.previewElement).attr('data-server', response);
                        $.get('/admin/properties/add-image', { property_id: property_id, image: response }, function(data) {
                            modalElement.find('ul#images').append(data);
                            $(file.previewElement).remove();
                            update_row();
                        }).fail(function(data) {
                            alert(data.statusText)
                        });
                    });
                    this.on("removedfile", function(file) {
                        //anything to do for now
                    });
                    this.on("error", function(file, response) {
                        $(file.previewElement).find('.dz-error-message span').html(translate.dictResponseError)
                    });
                    this.on("complete", function() {
                        uploading = false;
                    });
                }
            });
        };
        var activate_images_edition = function() {
            modalElement.on('click', 'a.set_front', setFront);
            modalElement.on('click', 'a.edit_image', function(e) {
                $(e.target).parents('li').find('.edition').toggle();
            });
            modalElement.on('click', '.button.cancel', function(e) {
                var ta = $(e.target).parents('li').find('textarea');
                ta.val(ta.data('description'));
                $(e.target).parents('li').find('.edition').hide()
            });
            modalElement.on('click', '.button.ok', function(e) {
                var ta = $(e.target).parents('li').find('textarea');
                var description = ta.val();
                var image_id = $(e.target).parents('li').data('id');
                ta.attr('disabled', 'disabled');
                $.post('/admin/properties/set-image-description', { image_id: image_id, description: description }, function(data) {
                        ta.data('description', data);
                        ta.val(data);
                        $(e.target).parents('li').find('.edition').hide()
                    })
                    .fail(function(data) {
                        alert(data.statusText);
                    }).always(function() {
                        ta.removeAttr('disabled');
                    });
            });
            modalElement.on('click', 'a.delete_image', function(e) {
                if (!confirm('You are deleting an image. Are you sure?'))
                    return;
                var element = $(e.target).parents('li');
                var image_id = element.data('id');
                $.post('/admin/properties/delete-image', { image_id: image_id }, function(data) {
                    if (data) {
                        element.remove();
                        update_row();
                    }
                }).fail(function(data) {
                    alert(data.statusText)
                });
            })
        };
        //END MODAL IMAGES FUNCTIONS
        //MODAL REVIEWS FUNCTIONS
        var load_comments = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/comments', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_comments();
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_comments = function() {
            modalElement.on('click', 'a.command.publish', function(e) {
                var tr = $(e.target).parents('tr');
                var id = tr.data('id');
                $.post('/admin/properties/toggle-review', { review_id: id }, function(data) {
                    if (data) {
                        tr.find('a.publish i').toggleClass('fa-square-o');
                        tr.find('a.publish i').toggleClass('fa-check-square-o');
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
            modalElement.on('click', 'a.command.delete', function(e) {
                var tr = $(e.target).parents('tr');
                var id = tr.data('id');
                $.post('/admin/properties/delete-review', { review_id: id }, function(data) {
                    if (data) {
                        tr.remove();
                        update_row();
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
        };
        //END MODAL REVIEWS FUNCTIONS
        //MODAL CONTACT FUNCTIONS
        var load_contacts = function(e) {
            var property_id = $(e.target).parents('tr').attr('id');
            var td = $(e.target).parents('td');
            var id = td.attr('id').substr(1);
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/contacts', { contact_id: id, property_id: property_id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_contacts();
                }).fail(function(data) {
                    alert(data.statusText);
                })
            });
            modal.open();
        };
        var activate_contacts = function() {
            modalElement.on('click', '.button.save', function(e) {
                e.preventDefault();
                var form_data = $(e.target).parents('form').serialize();
                $.post('/admin/properties/set-contact', form_data, function(data) {
                    if (data) {
                        modal.close();
                        update_row();
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
            modalElement.on('click', '.button.cancel', function(e) {
                e.preventDefault();
                modal.close();
            });
        };
        //END MODAL CONTACT FUNCTIONS
        //MODAL ACTION FUNCTIONS
        var load_actions = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/actions', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_actions();
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_actions = function() {
            modalElement.on('click', '.button.save', function(e) {
                e.preventDefault();
                var form_data = $(e.target).parents('form').serialize();
                $(e.target).parents('form').find('input, textarea').attr('disabled', 'disabled');
                $.post('/admin/properties/set-action', form_data, function(data) {
                    update_row();
                }).fail(function(data) {
                    alert(data.statusText);
                }).always(function() {
                    $(e.target).parents('form').find('input, textarea').removeAttr('disabled');
                });
            });
            modalElement.on('click', 'a.button.change', function(e) {
                e.preventDefault();
                var id = modalElement.find('input#id_action').val();
                $.post('/admin/properties/set-action', { type: 'change', id: id }, function(data) {
                    var badget;
                    $.each(modalElement.find('.badget'), function(index, elem) {
                        if ($(elem).data('id') == id) {
                            badget = $(elem);
                        }
                    });
                    if (data.action_id === 2) {
                        badget.text('PERMUTA');
                        badget.removeClass('venta').addClass('permuta');
                        $('input.price_condition').val(data.condition);
                    } else {
                        badget.text('VENTA');
                        badget.removeClass('permuta').addClass('venta');
                        $('input.price_condition').val(data.price);
                    }
                    update_row();
                });
            });
            modalElement.on('click', 'a.button.delete', function(e) {
                e.preventDefault();
                var form = $(e.target).parents('form');
                var property = $(this).data('property');
                var action = $(this).data('action');
                $.post('/admin/properties/delete-action', { property_id: property, action_id: action }, function(data) {
                    if (data == 1) {
                        alert('The action has been delete');
                        form.remove();
                        update_row();
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
            modalElement.on('click', 'a.button.new', function(e) {
                e.preventDefault();
                var form_data = $(e.target).parents('form').serialize();
                $(e.target).parents('form').find('input, textarea').attr('disabled', 'disabled');
                $.post('/admin/properties/set-action', form_data, function(data) {
                    if (data.id) {
                        $(e.target).parents('form').html('<h3>SUCCESS, PLEASE CLOSE DIALOG AND OPEN IT AGAIN</h3>');
                        update_row();
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                }).always(function() {
                    $(e.target).parents('form').find('input, textarea').removeAttr('disabled');
                });
            });
        };
        //END MODAL ACTION FUNCTIONS
        //MODAL TIME FUNCTIONS
        var load_days = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/days', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_days(id);
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_days = function(property_id) {
            modalElement.on('click', '.button.reset', function(e) {
                e.preventDefault();
                $.post('/admin/properties/reset-days', { property_id: property_id }, function(data) {
                    modalElement.find('.calculate').text(data.calculate);
                    modalElement.find('.base_date').text(data.base_date);
                    update_row();
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
            modalElement.on('click', '.button.add', function(e) {
                e.preventDefault();
                var days = modalElement.find('#days');
                if (isNaN(days.val()))
                    return;
                $.post('/admin/properties/add-days', { property_id: property_id, days: days.val() }, function(data) {
                    modalElement.find('.calculate').text(data.calculate);
                    modalElement.find('.base_date').text(data.base_date);
                    days.val('');
                    update_row();
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
        };
        //END MODAL DAYS FUNCTIONS
        //MODAL RENOVATE FUNCTIONS
        var renovate_plan = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/renovate', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_renovation(id);
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_renovation = function(id) {
            modalElement.off('click').on('click', '.renovate', function(e) {
                e.preventDefault();
                var plan = $('select#plan').val();
                var provider = $('select#provider').val();
                var payment = $('select#payment').val();
                var note = $('#note').val();
                var real = $('#real').val();
                $.post('/admin/properties/renovate', { id: id, plan: plan, provider: provider, payment: payment, note: note, real: real },
                    function(data) {
                        if (data) {
                            modal.close();
                            update_row();
                        }
                    }).fail(function(xhr) {
                    alert(xhr.statusText);
                });
            })
        };
        //MODAL REVO FUNCTIONS
        var load_revo = function(e) {
            e.preventDefault();
            var id = $(e.target).parents('tr').attr('id');
            modalElement.on('open.zf.reveal', function() {
                $.get('/admin/properties/revo', { property_id: id }, function(data) {
                    modalElement.find('.container').html(data);
                    activate_revo();
                }).fail(function(error) {
                    console.log(error);
                    modalElement.find('.container').html(error.statusText);
                });
            });
            modal.open();
        };
        var activate_revo = function() {
            modalElement.on('click', '#pictures li', function(e) {
                $(e.target).parent('li').toggleClass('selected');
            });
            $('#send_announce').click(function(e) {
                var pictures = $('#pictures').find('li.selected');
                var srcs = [];
                var counter = 0;
                pictures.each(function(index, el) {
                    if (counter == 3)
                        return;
                    srcs.push($(el).data('src'));
                    counter++;
                });
                $('#form_pictures').val(srcs);
                var d = $('#announce').serialize();
                $.post('/admin/properties/revo-send', d, function(data) {
                    if (data == '1') {
                        update_row();
                        modal.close();
                    } else {
                        alert(data);
                    }
                }).fail(function(data) {
                    alert(data.statusText);
                });
            });
        };
        //END MODAL FUNCTIONS
        var toggle_active = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            $.post('/admin/properties/toggle-active', { property_id: id }, function(data) {
                alert('Operation SUCCESS');
            }).fail(function(data) {
                alert(data.statusText);
            });
        };
        var toggle_concluded = function(e) {
            var id = $(e.target).parents('tr').attr('id');
            $.post('/admin/properties/toggle-concluded', { property_id: id }, function(data) {
                alert('Operation SUCCESS')
            }).fail(function(data) {
                alert(data.statusText);
            });
        };
        var search = function() {
            var query = $('#query').val();
            var order = orderBy.val();
            loader.open();
            $.get('/admin/properties/search', { query: query, only: filters_list.join(), order: order }, function(data) {
                table_properties.find('tbody tr').remove();
                table_properties.find('tbody').html(data);
            }).fail(function(data) {
                alert(data.statusText);
            }).always(function() {
                loader.close();
            });
        };
        var edit_filters = function(e) {
            var element = $(e.target);
            if (element.hasClass('button')) {
                var f = showOnly.val();
                if (f != null) {
                    if (filters_list_now.indexOf(f) == -1) {
                        filters_list_now.push(f);
                        filters_list_element.append('<span class="mini_badget">' + f + '<i class="fa fa-trash"></span>');
                        $('option#' + f).hide();
                        showOnly.val('');
                    }
                }
            } else {
                f = element.parents('span').text();
                if (filters_list_now.indexOf(f) > -1) {
                    delete filters_list_now[filters_list_now.indexOf(f)];
                    $('option#' + f).show();
                    element.parents('span').remove();
                }
            }
        };
        var accept_filters = function(e) {
            filters_list = [];
            main_filters.find('ul').html('');
            for (var f in filters_list_now) {
                if (filters_list_now[f]) {
                    filters_list.push(filters_list_now[f]);
                    main_filters.find('ul').append('<li><span class="mini_badget">' + filters_list_now[f] + '</span></li>');
                }
            }
            search();
        };
        var delete_prop = function(e) {
            e.preventDefault();
            var id = $(e.target).parents('tr').attr('id');
            if (!confirm('seguro desea eliminar la propiedad ' + id)) {
                return;
            }
            $.post('/admin/properties/delete', { property_id: id }, function(data) {
                $('tr#' + id).remove();
                alert('La propiedad, sus fotos, comentarios, operaciones, calificaciones y usuario han sido eliminados');
            }).fail(function(data) {
                alert(data.statusText);
            });
        };
        var setFront = function(e) {
            var image_id = $(e.target).parents('li').data('id');
            $.post('/admin/properties/set-image-front', { image_id: image_id }, function(data) {
                $('ul#images').find('li').removeClass('front');
                if (data == 1) {
                    $(e.target).parents('li').addClass('front');
                }
            }).fail(function(xhr) {
                alert(xhr.statusText);
            });
        };
    }
})();
$(document).ready(function() {
    var prop = new PROPERTY_ADMIN();
    prop.init();
});
