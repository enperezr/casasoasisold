var GUIDE = (function(){
    return function(){
        var action, contact, inmueble, continueToaction, continueToInmueble, continueToEnd, numbers, backToAction,
            backToContact, deseoVender, deseoPermutar, deseoVenderPermutar, actionChoice, contactData, actionData,
            choiceScreen, nextProperty, endSaving, savingPanel, submitContact, submitAction;
        var multiple = -1;
        var inmueblesData = [];

        this.init = function(){
            action = $('.block-form.action');
            contact = $('.block-form.contact');
            inmueble = $('.block-form.inmueble');
            continueToaction = $('#continue1');
            continueToInmueble = $('#continue2');
            continueToEnd = $('#continue3');
            backToAction = $('#back2');
            backToContact = $('#back1');
            numbers = $('#numbers');
            deseoVender = $('#dvender');
            deseoPermutar = $('#dpermutar');
            deseoVenderPermutar = $('#dvenderpermutar');
            actionChoice = $('#choice');
            choiceScreen = $('#choiceScreen');
            nextProperty = $('#next-property');
            endSaving = $('#end-property');
            savingPanel = $('#savingPanel');
            submitContact = $('#submit-contact');
            submitAction = $('#submit-action');
            backToAction.click(showActionForm);
            backToContact.click(showContactForm);
            continueToEnd.click(continueToEndAction);
            nextProperty.click(resetInmuebleForm);
            endSaving.click(saveAll);
            continueToaction.click(function(e) {
                e.preventDefault();
                if(formContact.isValid())
                    showActionForm(e);
            });
            continueToInmueble.click(function(e){
                e.preventDefault();
                if(formAction.isValid()){
                    if(formAction.getValue('#action') == 1){
                        var price = parseInt(formAction.getValue('#price'));
                        if(!isNaN(price) && price < 1000){
                            if(!confirm(translate.dictSurePrice)){
                                formAction.getElement();
                                return;
                            }
                        }

                    }
                    showInmuebleForm(e);
                }

            });
            submitContact.click(function(e){
                e.preventDefault();
                if(formContact.isValid()){
                    sendContactOnly()
                }
            });
            submitAction.click(function(e){
                e.preventDefault();
                if(formContact.isValid() && formAction.isValid()){
                    sendContactAction();
                }
            });
            $('.hidden').hide();
            contact.show();
        };

        var showContactForm = function(e){
            e.preventDefault();
            numbers.find('li').removeClass('active');
            $('.first').addClass('active');
            $('.hidden').hide();
            contact.show();
        };

        var showActionForm = function(e){
            e.preventDefault();
            numbers.find('li').removeClass('active');
            $('.second').addClass('active');
            $('.hidden').hide();
            action.show();
        };

        var showInmuebleForm = function(e){
            e.preventDefault();
            numbers.find('li').removeClass('active');
            $('.third').addClass('active');
            $('.hidden').hide();
            inmueble.show();
        };

        var continueToEndAction = function(e){
            e.preventDefault();
            if(!formProperty.isValid()){
                return false;
            }
            if(multiple == -1){
                if(formAction.getValue('#action') == 2){ //it's a permuta
                    var quantity = parseInt(formAction.getValue('#option').substr(0, 1));
                    if(quantity > 1){
                        multiple = quantity;
                    }
                }
                else
                    multiple = 1;
                contactData = formContact.getData();
                actionData = formAction.getData();
            }
            inmueblesData.push(formProperty.getData());
            multiple--;
            if(multiple > 0){
                formProperty.reset();
                showChoiceScreen()
            }
            else{
                saveAll(e);
            }
        };

        var startProcessingImages = function(data){
            var TOTAL = 0;
            $.each(data, function(index, value){
                if(value.images) {
                    var images = value.images[0];
                    var message = translate.dictMessageImagesProcessingGeneric;
                    savingPanel.find('#message').html(message);
                    startSpinning();
                    function processMore(processed) {
                        savingPanel.find('#message').html(translate.dictMessageImagesProcessed.replace('{total}', processed));
                        if (!$.isEmptyObject(images)) {
                            HELPERS.ajaxPost('/new-property/process-images', {
                                'images': HELPERS.spliceObject(images, [0, 3]),
                                'property': value.property.id
                            }, processMore)
                        }
                        else {
                            TOTAL++;
                            if (TOTAL == data.length) {
                                stopSpinning();
                                message = translate.dictMessageImagesProcessingDone.replace('{code}', value.code);
                                savingPanel.find('#message').html(message);
                            }
                        }
                    }

                    HELPERS.ajaxPost('/new-property/process-images', {
                        'images': HELPERS.spliceObject(images, [0, 3]),
                        'property': value.property.id
                    }, processMore)
                }
            });
        };

        var stopSpinning = function(){
            $('#spinner').hide();
        };

        var startSpinning = function(){
            $('#spinner').show();
        };

        var showChoiceScreen = function(){
            $('.hidden').hide();
            var total = formAction.getValue('#option').substr(0, 1);
            choiceScreen.find('.total').html(total+'');
            choiceScreen.find('.actual').html(total-multiple+'');
            choiceScreen.show();
        };

        var resetInmuebleForm = function(e){
            e.preventDefault();
            formProperty.reset();
            $('.hidden').hide();
            showInmuebleForm(e);
        };

        var sendContactOnly = function(){
            contactData = formContact.getData();
            $('.hidden').hide();
            savingPanel.show();
            startSpinning();
            $.post('/new-property/save-contact', contactData, function(data){
                var message = '';
                stopSpinning();
                if(!data.code) {
                    message = translate.dictMessageRegisteredUserSavedProperty;
                    savingPanel.find('#message').html(message);
                }
                else{
                    message = translate.dictMessageSavedProperty + data.code;
                    savingPanel.find('#message').html(message);
                }
            });
        };

        var sendContactAction = function(){
            contactData = formContact.getData();
            actionData = formAction.getData();
            var allData = contactData+'&'+actionData;
            $('.hidden').hide();
            savingPanel.show();
            startSpinning();
            $.post('/new-property/save-contact-action', allData, function(data){
                var message = '';
                stopSpinning();
                if(!data.code) {
                    message = translate.dictMessageRegisteredUserSavedProperty;
                    savingPanel.find('#message').html(message);
                }
                else{
                    message = translate.dictMessageSavedProperty + data.code;
                    savingPanel.find('#message').html(message);
                }
            });
        };

        var saveAll = function(e){
            if(!$('#tos').prop('checked')){
                inmueblesData = [];
                alert(translate.dictAcceptTos);
                var check = $('#tos');
                check.focus();
                check.highlight();
                return false;
            }
            $('.hidden').hide();
            savingPanel.show();
            startSpinning();
            $.post('/new-property/save-all', {contact:contactData, action: actionData, inmuebles:inmueblesData}, function(data){
                $('.hidden').hide();
                savingPanel.show();
                var message = '';
                stopSpinning();
                if(!data[0].code) {
                    message = translate.dictMessageRegisteredUserSavedProperty;
                    savingPanel.find('#message').html(message);
                }
                else{
                    message = translate.dictMessageSavedProperty;
                    savingPanel.find('#message').html(message);
                }
                var im = false;
                $.each(data, function(index, value){
                    if(value.images)
                        im = true;
                });
                if(im){
                    startSpinning();
                    startProcessingImages(data)
                }

            }).fail(function(xhr){
                if(xhr.responseText)
                    alert(xhr.responseText);
                else
                    alert(xhr.statusText);
                stopSpinning();
                savingPanel.hide();
                inmueble.show();
            });
        };
    }
})();

$(document).ready(function(){
    var guide = new GUIDE();
    guide.init();
});