var CREATE = (function() {
    return function() {

        var cache = { 'municipios': {}, 'localities': {}, 'extras': {} };
        var uploading = false;
        var localityElement, provinceElement, municipioElement, operationElement, formElement, typeElement, extrasElement, loaderElement, propertyInfoPanel, imagesPanel, savingWindowPanel,
            rentaElements, permutaElements, compraElements, saveElement, deleteImageTrigger, imageStack;

        this.init = function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            localityElement = $('#locality');
            provinceElement = $('#province');
            municipioElement = $('#municipio');
            operationElement = $('#operation');
            deleteImageTrigger = $('a.delete');
            typeElement = $('#type');
            formElement = $('#property-form');
            saveElement = $('#end');

            extrasElement = $('#commodities').find('div.option');
            loaderElement = $('#overlay');

            imagesPanel = $('#pictures');
            savingWindowPanel = $('#saving-window');

            rentaElements = $('.rentar');
            permutaElements = $('.permutar');
            compraElements = $('.comprar');

            prepareLayout();
            imageStack = [];

            provinceElement.change(updateMunicipioLocality);
            municipioElement.change(updateLocality);
            typeElement.change(updateExtras);
            operationElement.change();
            deleteImageTrigger.click(deleteImage);
            saveElement.click(function(e) {
                e.preventDefault();
                submitAll();
            });

            updateExtras(typeElement.find('option').filter(':selected').data('group'));

            $('#dropzone-area').dropzone({
                autoDiscover: false,
                maxFilesize: 3,
                previewsContainer: '#previews',
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
                        imageStack.push(response);
                        $(file.previewElement).attr('data-server', response);
                        $(file.previewElement).after('<div class="image-description" id="' + response + '"><label>' + translate.dictDescription + '</label><textarea name="' + response + '"></textarea></div>');

                    });
                    this.on("removedfile", function(file) {
                        var id = $(file.previewElement).attr('data-server');
                        $('#' + id).remove();
                        for (var i = 0; i < imageStack.length; i++) {
                            if (imageStack[i] == id) {
                                imageStack.splice(i, 1);
                                break;
                            }
                        }
                    });
                    this.on("error", function(file, response) {
                        $(file.previewElement).find('.dz-error-message span').html(translate.dictResponseError)
                    });
                    this.on("complete", function() {
                        uploading = false;
                    });
                }
            });
            formElement.validator({ acceptEmpty: true });

        };

        var prepareLayout = function() {
            savingWindowPanel.hide();
        };

        var submitAll = function() {
            if (uploading) {
                alert(translate.dictMessageWaitForImage);
                return;
            }
            var property = formElement.serialize();
            var images = $('.image-description').find('textarea').serialize();
            formElement.hide();
            imagesPanel.hide();
            loaderElement.show();
            showSavingState(false);
            ajaxPost('/new-property/save-data-images', property + '&' + images, function(data) {
                if (!data.images || data.images.length == 0) {
                    showSavingState(true);
                } else {
                    var images = data.images;
                    loaderElement.find('.loader').html(data.message);

                    function proccesMore(more) {
                        if (!$.isEmptyObject(images)) {
                            var message = translate.dictMessageImagesProcessing.replace('{total}', countObjectArgs(images));
                            loaderElement.find('.loader').html(message);
                            ajaxPost('/new-property/process-images', { 'images': spliceObject(images, [0, 3]), 'property': data.property }, proccesMore)
                        } else {
                            showSavingState(true);
                        }
                    }
                    ajaxPost('/new-property/process-images', { 'images': spliceObject(images, [0, 3]), 'property': data.property }, proccesMore)
                }
            });
        };

        var updateMunicipioLocality = function(e) {
            var value = e.target ? e.target.value : e;

            function waitOrNot() {
                var municipios = cache.municipios[value];
                municipioElement.find('option').remove();
                $.each(municipios, function(key, value) {
                    municipioElement.append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                updateLocality(municipios.slice(0, 1)[0].id)
            }
            if (!cache.municipios[value]) {
                ajaxGet('/municipios/' + value, {}, function(data) {
                    cache.municipios[value] = data.municipios;
                    cache.localities[data.municipios[0].id] = data.localities;
                    waitOrNot()
                })
            } else {
                waitOrNot()
            }

        };

        var updateLocality = function(e) {
            var value = e.target ? e.target.value : e;

            function waitOrNot() {
                var localities = cache.localities[value];
                localityElement.find('option.dynamic').remove();
                var unspecified = null;
                $.each(localities, function(key, value) {
                    if (value.name === 'unspecified') {
                        value.name = translate[value.name];
                        unspecified = value.id;
                    }
                    localityElement.append('<option class="dynamic" value="' + value.id + '">' + value.name + '</option>');
                });
                localityElement.val(unspecified);
            }
            if (!cache.localities[value]) {
                ajaxGet('/localities/' + value, {}, function(data) {
                    cache.localities[value] = data;
                    waitOrNot();
                })
            } else {
                waitOrNot();
            }

        };

        var updateExtras = function(e) {
            var value = e.target ? $(e.target).find('option').filter(':selected').data('group') : e;

            function waitOrNot() {
                var extras = cache.extras[value];
                extrasElement.each(function(index, element) {
                    var actual = $(element).find('input')[0].value;
                    $(element).css('display', 'none');
                    for (var i in extras) {
                        if (actual == extras[i].id && (operationElement.value != 'rentar' || !$(element).hasClass('comprar'))) {
                            $(element).css('display', 'inline-block');
                            break;
                        }
                    }
                });
            }
            if (!cache.extras[value]) {
                ajaxGet('/commodities/' + value, {}, function(data) {
                    cache.extras[value] = data;
                    waitOrNot();
                })
            } else {
                waitOrNot();
            }
        };

        var showSavingState = function(saved) {
            savingWindowPanel.show();
            if (!saved) {
                savingWindowPanel.find('.saving').show();
                savingWindowPanel.find('.saved').hide();
            } else {
                savingWindowPanel.find('.saving').hide();
                savingWindowPanel.find('.saved').show();
            }
        };

        var ajaxGet = function(url, args, f) {
            $.get(url, args || {}, f);
        };

        var ajaxPost = function(url, args, success, fail, always) {
            $.post(url, args || {}, success).fail(fail).always(always)
        };

        var spliceObject = function(obj, interval) {
            var i = 0,
                j = 0,
                r = {};
            for (index in obj) {
                if (obj.hasOwnProperty(index)) {
                    if (i >= interval[0]) {
                        if (j < interval[1]) {
                            r[index] = obj[index];
                            delete obj[index];
                            j++;
                        }
                    }
                    i++;
                }
            }
            return r
        };

        var countObjectArgs = function(obj) {
            var total = 0;
            for (index in obj) {
                if (obj.hasOwnProperty(index)) {
                    total++;
                }
            }
            return total;
        };

        var deleteImage = function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.post('/user/delete-image', { id: id }, function(data) {
                if (data == '1') {
                    $(e.target).parents('.image').remove();
                }
            });
        };

        this.isValid = function() {
            return formElement.validate();
        };

        this.getData = function() {
            var images = {};
            $.each(imageStack, function(index, value) {
                images[value] = $('textarea[name="' + value + '"]').val();
            });
            return [formElement.serialize(), images]
        };

        this.reset = function() {
            imageStack = [];
            $('#previews').empty();
            formElement[0].reset();
        }
    }
})();
var formProperty = new CREATE();
$(function() {
    formProperty.init();
});
